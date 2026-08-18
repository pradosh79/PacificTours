<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Enums\TourStatus;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_tour_list_is_public_and_paginated(): void
    {
        Tour::factory()->count(15)->create(['status' => TourStatus::Published]);

        $this->getJson('/api/v1/tours?per_page=10')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [['id', 'title', 'slug', 'duration', 'price', 'rating']],
                'meta' => ['current_page', 'last_page', 'total'],
            ]);
    }

    public function test_draft_tours_never_appear_in_the_public_api(): void
    {
        $draft = Tour::factory()->create(['status' => TourStatus::Draft]);

        $this->getJson('/api/v1/tours')->assertOk()->assertJsonMissing(['slug' => $draft->slug]);
        $this->getJson("/api/v1/tours/{$draft->slug}")->assertNotFound();
    }

    public function test_price_filters_narrow_the_result_set(): void
    {
        Tour::factory()->create(['sale_price' => 100, 'status' => TourStatus::Published]);
        Tour::factory()->create(['sale_price' => 5000, 'status' => TourStatus::Published]);

        $this->getJson('/api/v1/tours?price_max=1000')
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_an_unknown_slug_returns_404_rather_than_an_error(): void
    {
        $this->getJson('/api/v1/tours/does-not-exist')->assertNotFound();
    }
}
