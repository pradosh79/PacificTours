<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\PaymentResult;
use App\Enums\PaymentType;
use App\Enums\TransactionStatus;
use App\Events\PaymentCaptured;
use App\Events\PaymentFailed;
use App\Exceptions\PaymentException;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentLog;
use App\Models\Refund;
use App\Models\WebhookEvent;
use App\Services\Payment\PaymentGatewayManager;
use Illuminate\Support\Facades\DB;

/**
 * Gateway-agnostic money ledger. Amounts are always recomputed server side from
 * the booking, never taken from the request.
 */
class PaymentService
{
    public function __construct(
        private readonly PaymentGatewayManager $gateways,
        private readonly BookingService $bookings,
    ) {}

    /** Opens a transaction with the chosen gateway and records an `initiated` row. */
    public function initiate(Booking $booking, string $gatewayKey, PaymentType $type = PaymentType::Full): PaymentResult
    {
        $amount  = $this->amountFor($booking, $type);
        $gateway = $this->gateways->driver($gatewayKey);

        $payment = $booking->payments()->create([
            'user_id'    => $booking->user_id,
            'invoice_id' => $booking->invoice?->id,
            'gateway'    => $gatewayKey,
            'type'       => $type,
            'amount'     => $amount,
            'currency'   => $booking->currency,
            'status'     => TransactionStatus::Initiated,
            'ip_address' => request()->ip(),
        ]);

        try {
            $result = $gateway->charge($booking, $amount, ['type' => $type->value]);

            $payment->update([
                'transaction_id'    => $result->transactionId,
                'gateway_reference' => $result->reference,
                'status'            => TransactionStatus::Pending,
                'gateway_payload'   => $result->raw,
            ]);

            $this->log($payment, 'charge.created', 'outgoing', ['amount' => $amount], $result->raw);

            return $result;
        } catch (\Throwable $e) {
            $payment->update(['status' => TransactionStatus::Failed, 'failure_reason' => $e->getMessage()]);
            $this->log($payment, 'charge.failed', 'outgoing', ['amount' => $amount], ['error' => $e->getMessage()]);

            throw PaymentException::declined($e->getMessage());
        }
    }

    /** Called on gateway return. Idempotent: replaying the callback is a no-op. */
    public function settle(Booking $booking, string $gatewayKey, array $payload): Payment
    {
        $result = $this->gateways->driver($gatewayKey)->verify($payload);

        return DB::transaction(function () use ($booking, $gatewayKey, $result): Payment {
            $payment = Payment::where('gateway', $gatewayKey)
                ->where(fn ($q) => $q->where('transaction_id', $result->transactionId)
                    ->orWhere('gateway_reference', $result->reference))
                ->lockForUpdate()
                ->firstOrFail();

            if ($payment->status === TransactionStatus::Succeeded) {
                return $payment;   // already settled
            }

            if (! $result->success) {
                $payment->update(['status' => TransactionStatus::Failed, 'failure_reason' => $result->message]);
                PaymentFailed::dispatch($payment);

                return $payment;
            }

            if (round($result->amount, 2) !== round((float) $payment->amount, 2)) {
                $this->log($payment, 'amount.mismatch', 'incoming', ['expected' => $payment->amount], $result->raw);

                throw PaymentException::amountMismatch();
            }

            $payment->update([
                'status'          => TransactionStatus::Succeeded,
                'transaction_id'  => $result->transactionId,
                'paid_at'         => now(),
                'gateway_payload' => $result->raw,
            ]);

            $this->log($payment, 'charge.succeeded', 'incoming', [], $result->raw);
            $this->bookings->syncPaymentTotals($booking->refresh());

            PaymentCaptured::dispatch($payment->refresh());

            return $payment;
        });
    }

    /** Records an office payment (cash, e-transfer, cheque) taken by staff. */
    public function recordManual(Booking $booking, float $amount, string $gatewayKey = 'manual', ?string $note = null, ?PaymentType $type = null): Payment
    {
        return DB::transaction(function () use ($booking, $amount, $gatewayKey, $note, $type): Payment {
            $result = $this->gateways->driver($gatewayKey)->charge($booking, $amount, ['note' => $note]);

            $payment = $booking->payments()->create([
                'user_id'        => auth()->id() ?? $booking->user_id, // staff member if signed in, else the customer
                'invoice_id'     => $booking->invoice?->id,
                'gateway'        => $gatewayKey,
                'type'           => $type ?? ($amount >= (float) $booking->due_amount ? PaymentType::Balance : PaymentType::Partial),
                'transaction_id' => $result->transactionId,
                'amount'         => $amount,
                'currency'       => $booking->currency,
                'status'         => TransactionStatus::Succeeded,
                'paid_at'        => now(),
            ]);

            $this->bookings->syncPaymentTotals($booking->refresh());
            PaymentCaptured::dispatch($payment);

            return $payment;
        });
    }

    public function refund(Payment $payment, float $amount, ?string $reason = null): Refund
    {
        if ($amount > $payment->refundable_amount) {
            throw PaymentException::refundExceedsCapture();
        }

        return DB::transaction(function () use ($payment, $amount, $reason): Refund {
            $refund = Refund::create([
                'payment_id'   => $payment->id,
                'booking_id'   => $payment->booking_id,
                'amount'       => $amount,
                'reason'       => $reason,
                'status'       => 'processing',
                'requested_by' => auth()->id(),
            ]);

            $result = $this->gateways->driver($payment->gateway->value)->refund($payment, $amount, $reason);

            $refund->update([
                'status'            => $result->success ? 'completed' : 'failed',
                'gateway_refund_id' => $result->transactionId,
                'processed_by'      => auth()->id(),
                'processed_at'      => now(),
            ]);

            $this->log($payment, 'refund.'.($result->success ? 'succeeded' : 'failed'), 'outgoing', ['amount' => $amount], $result->raw);
            $this->bookings->syncPaymentTotals($payment->booking->refresh());

            return $refund;
        });
    }

    /** Stores the raw webhook once (unique on gateway+event_id) for replay-safe processing. */
    public function recordWebhook(string $gatewayKey, array $event): ?WebhookEvent
    {
        if (blank($event['id'])) {
            return null;
        }

        return WebhookEvent::firstOrCreate(
            ['gateway' => $gatewayKey, 'event_id' => $event['id']],
            ['type' => $event['type'], 'payload' => $event['payload'], 'status' => 'received']
        );
    }

    public function amountFor(Booking $booking, PaymentType $type): float
    {
        return match ($type) {
            PaymentType::Deposit => (float) $booking->deposit_amount ?: (float) $booking->grand_total,
            PaymentType::Balance => (float) $booking->due_amount,
            default              => (float) $booking->due_amount ?: (float) $booking->grand_total,
        };
    }

    private function log(Payment $payment, string $event, string $direction, array $request, array $response): void
    {
        PaymentLog::create([
            'payment_id'       => $payment->id,
            'gateway'          => $payment->gateway->value,
            'event'            => $event,
            'direction'        => $direction,
            'request_payload'  => $request,
            'response_payload' => $response,
            'ip_address'       => request()->ip(),
        ]);
    }
}
