<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use App\Models\Destination;
use App\Models\TourCategory;
use App\Repositories\Contracts\TourRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class SearchService
{
    public function __construct(private readonly TourRepositoryInterface $tours) {}

    public function tours(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        return $this->tours->search($this->normalise($filters), $perPage);
    }

    /** Facet lists for the sidebar filter panel — cached, they change rarely. */
    public function facets(): array
    {
        return Cache::remember('search:facets', now()->addHour(), fn () => [
            'categories'   => TourCategory::active()->root()->withCount('tours')->orderBy('sort_order')->get(['id', 'name', 'slug']),
            'destinations' => Destination::active()->withCount('tours')->orderBy('name')->get(['id', 'name', 'slug']),
            'countries'    => Country::active()->has('tours')->orderBy('name')->get(['id', 'name', 'slug']),
            'cities'       => City::active()->has('tours')->orderBy('name')->get(['id', 'name', 'slug', 'country_id']),
            'durations'    => [
                ['label' => '1–3 days',  'min' => 1,  'max' => 3],
                ['label' => '4–7 days',  'min' => 4,  'max' => 7],
                ['label' => '8–14 days', 'min' => 8,  'max' => 14],
                ['label' => '15+ days',  'min' => 15, 'max' => 365],
            ],
            'price_range'  => [
                'min' => (float) \App\Models\Tour::published()->min('sale_price'),
                'max' => (float) \App\Models\Tour::published()->max('sale_price'),
            ],
        ]);
    }

    /** Type-ahead across tours and destinations. */
    public function suggest(string $term, int $limit = 8): array
    {
        return [
            'tours' => $this->tours->query()->published()
                ->where('title', 'like', "%{$term}%")
                ->limit($limit)->get(['id', 'title', 'slug', 'thumbnail', 'sale_price']),
            'destinations' => Destination::active()
                ->where('name', 'like', "%{$term}%")
                ->limit($limit)->get(['id', 'name', 'slug']),
        ];
    }

    private function normalise(array $filters): array
    {
        return array_intersect_key($filters, array_flip([
            'keyword', 'category', 'destination', 'country', 'city', 'min_price', 'max_price',
            'min_duration', 'max_duration', 'rating', 'travel_date', 'available_only', 'featured', 'sort',
        ]));
    }
}
