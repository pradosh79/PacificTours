<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\Payment\PaymentGatewayManager;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * The gateway is the source of truth for payment state. Even if the customer
 * closes the tab before the return URL fires, the webhook settles the booking.
 */
class WebhookController extends Controller
{
    public function __construct(
        private readonly PaymentGatewayManager $gateways,
        private readonly PaymentService $payments,
    ) {}

    public function handle(Request $request, string $gateway)
    {
        try {
            $event = $this->gateways->driver($gateway)->parseWebhook($request->getContent(), $request->headers->all());
        } catch (\Throwable $e) {
            Log::warning('Rejected webhook', ['gateway' => $gateway, 'error' => $e->getMessage()]);

            return response()->json(['received' => false], 400);
        }

        $record = $this->payments->recordWebhook($gateway, $event);

        if (! $record || $record->processed_at) {
            return response()->json(['received' => true, 'duplicate' => true]);
        }

        try {
            $this->process($gateway, $event);
            $record->update(['processed_at' => now(), 'status' => 'processed']);
        } catch (\Throwable $e) {
            report($e);
            $record->update(['status' => 'failed', 'error' => $e->getMessage()]);
        }

        return response()->json(['received' => true]);
    }

    private function process(string $gateway, array $event): void
    {
        $succeeded = in_array($event['type'], [
            'checkout.session.completed', 'payment_intent.succeeded', 'PAYMENT.CAPTURE.COMPLETED',
        ], true);

        if (! $succeeded) {
            return;
        }

        $reference = data_get($event['payload'], 'data.object.id')
            ?? data_get($event['payload'], 'resource.id');

        $payment = Payment::where('gateway', $gateway)
            ->where(fn ($q) => $q->where('gateway_reference', $reference)->orWhere('transaction_id', $reference))
            ->first();

        if (! $payment) {
            return;
        }

        $this->payments->settle($payment->booking, $gateway, [
            'session_id' => $payment->gateway_reference,
            'token'      => $payment->gateway_reference,
        ]);
    }
}
