<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\NumberGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NumberGeneratorTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_numbers_follow_the_documented_shape(): void
    {
        $this->assertMatchesRegularExpression('/^PT-\d{4}-\d{6}$/', NumberGenerator::booking());
    }

    public function test_consecutive_numbers_never_repeat(): void
    {
        $numbers = collect(range(1, 50))->map(fn () => NumberGenerator::booking());

        $this->assertCount(50, $numbers->unique());
    }

    public function test_invoice_and_ticket_numbers_use_their_own_sequences(): void
    {
        $this->assertStringStartsWith('INV-', NumberGenerator::invoice());
        $this->assertStringStartsWith('TKT-', NumberGenerator::ticket());
    }
}
