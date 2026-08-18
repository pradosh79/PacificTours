<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\BookingStatus;
use PHPUnit\Framework\TestCase;

class BookingStatusTest extends TestCase
{
    public function test_pending_may_become_confirmed_or_cancelled(): void
    {
        $this->assertTrue(BookingStatus::Pending->canTransitionTo(BookingStatus::Confirmed));
        $this->assertTrue(BookingStatus::Pending->canTransitionTo(BookingStatus::Cancelled));
    }

    public function test_a_booking_cannot_skip_straight_from_pending_to_completed(): void
    {
        $this->assertFalse(BookingStatus::Pending->canTransitionTo(BookingStatus::Completed));
    }

    public function test_terminal_states_are_terminal(): void
    {
        foreach ([BookingStatus::Completed, BookingStatus::Refunded] as $terminal) {
            foreach (BookingStatus::cases() as $target) {
                $this->assertFalse(
                    $terminal->canTransitionTo($target),
                    "{$terminal->value} should not transition to {$target->value}"
                );
            }
        }
    }

    public function test_only_live_statuses_hold_seats(): void
    {
        $this->assertTrue(BookingStatus::Pending->seatHolding());
        $this->assertTrue(BookingStatus::Confirmed->seatHolding());
        $this->assertFalse(BookingStatus::Cancelled->seatHolding());
        $this->assertFalse(BookingStatus::Refunded->seatHolding());
    }
}
