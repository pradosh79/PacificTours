<?php

declare(strict_types=1);

namespace Tests\Feature\Booking;

use App\DTOs\BookingData;
use App\Exceptions\BookingException;
use App\Models\Tour;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * The single most expensive bug this system could ship is selling the same seat
 * twice, so it gets its own test class.
 */
class SeatConcurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_last_seat_can_only_be_sold_once(): void
    {
        $tour = Tour::factory()->create(['base_price' => 100]);

        $departure = $tour->departures()->create([
            'start_date'   => now()->addMonth(),
            'end_date'     => now()->addMonth()->addDay(),
            'seats_total'  => 5,
            'seats_booked' => 4,
            'status'       => 'open',
        ]);

        $service = app(BookingService::class);
        $data    = fn () => BookingData::fromArray([
            'tour_id'             => $tour->id,
            'tour_departure_id'   => $departure->id,
            'travel_date'         => $departure->start_date->toDateString(),
            'adults'              => 1,
            'customer_first_name' => 'Racer',
            'customer_email'      => 'race@example.com',
        ]);

        $service->create($data());

        $this->expectException(BookingException::class);
        $service->create($data());

        $this->assertSame(5, $departure->fresh()->seats_booked);
    }

    public function test_a_failed_booking_leaves_no_partial_rows_behind(): void
    {
        $tour = Tour::factory()->create();

        $departure = $tour->departures()->create([
            'start_date'   => now()->addMonth(),
            'end_date'     => now()->addMonth()->addDay(),
            'seats_total'  => 1,
            'seats_booked' => 1,
            'status'       => 'open',
        ]);

        $before = DB::table('bookings')->count();

        try {
            app(BookingService::class)->create(BookingData::fromArray([
                'tour_id'             => $tour->id,
                'tour_departure_id'   => $departure->id,
                'travel_date'         => $departure->start_date->toDateString(),
                'adults'              => 1,
                'customer_first_name' => 'Nope',
                'customer_email'      => 'nope@example.com',
            ]));
        } catch (BookingException) {
            // expected
        }

        $this->assertSame($before, DB::table('bookings')->count());
        $this->assertSame(0, DB::table('invoices')->count());
        $this->assertSame(0, DB::table('booking_travelers')->count());
    }
}
