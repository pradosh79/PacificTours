<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_quote_returns_a_full_price_breakdown_without_creating_anything(): void
    {
        $tour = Tour::factory()->create(['base_price' => 400]);

        $this->postJson('/api/v1/bookings/quote', [
            'tour_id'             => $tour->id,
            'travel_date'         => now()->addMonth()->toDateString(),
            'adults'              => 2,
            'customer_first_name' => 'Api',
            'customer_email'      => 'api@example.com',
        ])
            ->assertOk()
            ->assertJsonPath('data.subtotal', 800)
            ->assertJsonStructure(['data' => ['lines', 'subtotal', 'tax', 'total', 'payable_now', 'currency']]);

        $this->assertSame(0, Booking::count());
    }

    public function test_creating_a_booking_returns_201_and_a_booking_number(): void
    {
        $tour = Tour::factory()->create(['base_price' => 400]);

        $departure = $tour->departures()->create([
            'start_date'  => now()->addMonth(),
            'end_date'    => now()->addMonth()->addDay(),
            'seats_total' => 10,
            'status'      => 'open',
        ]);

        $this->postJson('/api/v1/bookings', [
            'tour_id'             => $tour->id,
            'tour_departure_id'   => $departure->id,
            'travel_date'         => $departure->start_date->toDateString(),
            'adults'              => 1,
            'customer_first_name' => 'Api',
            'customer_last_name'  => 'Tester',
            'customer_email'      => 'api@example.com',
            'customer_phone'      => '+1 604 555 0111',
            'terms'               => true,
        ])
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['data' => ['id', 'booking_number', 'status', 'total']]);
    }

    public function test_listing_bookings_requires_a_token(): void
    {
        $this->getJson('/api/v1/bookings')->assertUnauthorized();
    }

    public function test_a_token_only_ever_sees_its_own_bookings(): void
    {
        $mine   = User::factory()->create();
        $theirs = User::factory()->create();

        Booking::factory()->count(2)->create(['user_id' => $mine->id]);
        Booking::factory()->count(3)->create(['user_id' => $theirs->id]);

        Sanctum::actingAs($mine);

        $this->getJson('/api/v1/bookings')->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_booking_creation_is_rate_limited(): void
    {
        $tour = Tour::factory()->create();

        foreach (range(1, 11) as $attempt) {
            $response = $this->postJson('/api/v1/bookings', ['tour_id' => $tour->id]);
        }

        $response->assertStatus(429);
    }
}
