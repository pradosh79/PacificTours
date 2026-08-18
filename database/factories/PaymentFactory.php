<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PaymentGateway;
use App\Enums\PaymentType;
use App\Enums\TransactionStatus;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    protected $model = \App\Models\Payment::class;

    public function definition(): array
    {
        return [
            'uuid'              => Str::uuid(),
            'booking_id'        => Booking::factory(),
            'gateway'           => PaymentGateway::Manual,
            'type'              => PaymentType::Full,
            'amount'            => fake()->randomFloat(2, 50, 2000),
            'currency'          => 'CAD',
            'status'            => TransactionStatus::Pending,
            'transaction_id'    => null,
            'gateway_reference' => 'ref_'.Str::random(16),
            'gateway_payload'   => null,
        ];
    }

    public function succeeded(): static
    {
        return $this->state(fn () => [
            'status'         => TransactionStatus::Succeeded,
            'transaction_id' => 'txn_'.Str::random(20),
            'paid_at'        => now(),
        ]);
    }

    public function failed(string $reason = 'card_declined'): static
    {
        return $this->state(fn () => [
            'status'         => TransactionStatus::Failed,
            'failure_reason' => $reason,
        ]);
    }

    public function stripe(): static
    {
        return $this->state(fn () => ['gateway' => PaymentGateway::Stripe]);
    }
}
