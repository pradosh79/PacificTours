<?php

declare(strict_types=1);

namespace Tests\Feature\Booking;

use App\DTOs\BookingData;
use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Events\BookingCreated;
use App\Exceptions\BookingException;
use App\Models\Tour;
use App\Models\TourDeparture;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateBookingTest extends TestCase
{
    use RefreshDatabase;

    private Tour $tour;

    private TourDeparture $departure;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tour = Tour::factory()->create(['base_price' => 500, 'max_seats' => 10]);

        $this->departure = $this->tour->departures()->create([
            'start_date'  => now()->addMonth(),
            'end_date'    => now()->addMonth()->addDays(2),
            'seats_total' => 10,
            'status'      => 'open',
        ]);
    }

    public function test_it_creates_a_booking_with_travellers_an_invoice_and_a_held_seat(): void
    {
        Event::fake([BookingCreated::class]);

        $booking = app(BookingService::class)->create($this->payload(adults: 2));

        $this->assertSame(BookingStatus::Pending, $booking->status);
        $this->assertSame(PaymentStatus::Unpaid, $booking->payment_status);
        $this->assertSame(1000.0, (float) $booking->subtotal);
        $this->assertCount(2, $booking->travelers);
        $this->assertNotNull($booking->invoice);
        $this->assertSame(2, $this->departure->fresh()->seats_booked);

        Event::assertDispatched(BookingCreated::class);
    }

    public function test_it_records_the_opening_status_history_entry(): void
    {
        $booking = app(BookingService::class)->create($this->payload());

        $this->assertDatabaseHas('booking_status_histories', [
            'booking_id' => $booking->id,
            'to_status'  => BookingStatus::Pending->value,
        ]);
    }

    public function test_it_refuses_to_oversell_a_departure(): void
    {
        $this->departure->update(['seats_booked' => 9]);

        $this->expectException(BookingException::class);

        app(BookingService::class)->create($this->payload(adults: 3));
    }

    public function test_it_refuses_a_departure_that_has_already_left(): void
    {
        $this->departure->update([
            'start_date' => now()->subDay(),
            'end_date'   => now()->addDay(),
        ]);

        $this->expectException(BookingException::class);

        app(BookingService::class)->create($this->payload());
    }

    public function test_prices_are_frozen_on_the_booking_so_later_tour_edits_do_not_change_it(): void
    {
        $booking = app(BookingService::class)->create($this->payload(adults: 2));

        $this->tour->update(['base_price' => 9999, 'sale_price' => 9999]);

        $this->assertSame(500.0, (float) $booking->fresh()->adult_unit_price);
        $this->assertSame(1000.0, (float) $booking->fresh()->grand_total);
    }

    public function test_a_guest_can_book_without_an_account(): void
    {
        $booking = app(BookingService::class)->create($this->payload());

        $this->assertNull($booking->user_id);
        $this->assertSame('guest@example.com', $booking->customer_email);
    }

    private function payload(int $adults = 1): BookingData
    {
        return BookingData::fromArray([
            'tour_id'             => $this->tour->id,
            'tour_departure_id'   => $this->departure->id,
            'travel_date'         => $this->departure->start_date->toDateString(),
            'adults'              => $adults,
            'children'            => 0,
            'infants'             => 0,
            'customer_first_name' => 'Guest',
            'customer_last_name'  => 'Traveller',
            'customer_email'      => 'guest@example.com',
            'customer_phone'      => '+1 604 555 0100',
            'travelers'           => array_fill(0, $adults, ['type' => 'adult', 'first_name' => 'Guest', 'last_name' => 'Traveller']),
        ]);
    }
}
