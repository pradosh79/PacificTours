<?php

declare(strict_types=1);

namespace Tests\Feature\Payment;

use App\Enums\BookingStatus;
use App\Enums\PaymentGateway;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\TransactionStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettlePaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_settling_a_payment_marks_the_booking_paid_and_confirms_it(): void
    {
        $booking = Booking::factory()->create(['grand_total' => 500, 'due_amount' => 500]);

        $this->manualPayment($booking, 500);

        $booking->refresh();

        $this->assertSame(500.0, (float) $booking->paid_amount);
        $this->assertSame(0.0, (float) $booking->due_amount);
        $this->assertSame(PaymentStatus::Paid, $booking->payment_status);
        $this->assertSame(BookingStatus::Confirmed, $booking->status);
    }

    public function test_a_deposit_leaves_the_booking_partially_paid(): void
    {
        $booking = Booking::factory()->create(['grand_total' => 1000, 'due_amount' => 1000]);

        $this->manualPayment($booking, 250, PaymentType::Deposit);

        $booking->refresh();

        $this->assertSame(750.0, (float) $booking->due_amount);
        $this->assertSame(PaymentStatus::PartiallyPaid, $booking->payment_status);
    }

    public function test_replaying_the_same_gateway_reference_does_not_double_credit(): void
    {
        $booking = Booking::factory()->create(['grand_total' => 500, 'due_amount' => 500]);

        $payment = Payment::factory()->create([
            'booking_id'        => $booking->id,
            'gateway'           => PaymentGateway::Manual,
            'gateway_reference' => 'ref_duplicate',
            'amount'            => 500,
            'status'            => TransactionStatus::Pending,
        ]);

        $service = app(PaymentService::class);
        $service->settle($booking, 'manual', ['reference' => 'ref_duplicate']);
        $service->settle($booking, 'manual', ['reference' => 'ref_duplicate']);

        $this->assertSame(1, $booking->payments()->where('status', TransactionStatus::Succeeded)->count());
        $this->assertSame(500.0, (float) $booking->fresh()->paid_amount);
        $this->assertSame(TransactionStatus::Succeeded, $payment->fresh()->status);
    }

    public function test_the_paid_total_is_always_recomputed_from_the_payment_ledger(): void
    {
        $booking = Booking::factory()->create(['grand_total' => 900, 'due_amount' => 900]);

        $this->manualPayment($booking, 300, PaymentType::Deposit);
        $this->manualPayment($booking, 600, PaymentType::Balance);

        $booking->refresh();

        $this->assertSame(900.0, (float) $booking->paid_amount);
        $this->assertSame(0.0, (float) $booking->due_amount);
    }

    private function manualPayment(Booking $booking, float $amount, PaymentType $type = PaymentType::Full): void
    {
        app(PaymentService::class)->recordManual($booking, $amount, 'cash', 'test', $type);
    }
}
