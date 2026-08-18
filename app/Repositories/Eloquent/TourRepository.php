<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Booking;
use App\Models\Tour;
use App\Repositories\Contracts\TourRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TourRepository extends BaseRepository implements TourRepositoryInterface
{
    public function __construct(Tour $model)
    {
        parent::__construct($model);
    }

    public function search(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        return $this->query()
            ->published()
            ->with(['category:id,name,slug', 'destination:id,name,slug', 'country:id,name,slug'])
            ->filter($filters)
            ->when(empty($filters['sort']), fn ($q) => $q->orderByDesc('is_featured')->latest('id'))
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findBySlug(string $slug): ?Tour
    {
        return $this->query()
            ->published()
            ->with([
                'category', 'destination', 'country', 'city', 'images', 'itineraries',
                'inclusions', 'highlights', 'faqs', 'seo',
                'departures' => fn ($q) => $q->open()->orderBy('start_date')->limit(24),
                'approvedReviews' => fn ($q) => $q->with('images')->latest()->limit(10),
            ])
            ->where('slug', $slug)
            ->first();
    }

    public function featured(int $limit = 8): Collection
    {
        return Cache::remember("tours:featured:{$limit}", now()->addMinutes(15), fn () => $this->query()
            ->published()->featured()->with('destination:id,name,slug')
            ->orderByDesc('average_rating')->limit($limit)->get());
    }

    public function popular(int $limit = 8): Collection
    {
        return Cache::remember("tours:popular:{$limit}", now()->addMinutes(15), fn () => $this->query()
            ->published()->popular()->with('destination:id,name,slug')
            ->orderByDesc('bookings_count')->limit($limit)->get());
    }

    public function related(Tour $tour, int $limit = 4): Collection
    {
        return $this->query()
            ->published()
            ->where('id', '!=', $tour->id)
            ->where(fn ($q) => $q->where('tour_category_id', $tour->tour_category_id)
                ->orWhere('destination_id', $tour->destination_id))
            ->limit($limit)
            ->get();
    }

    public function topSelling(int $limit = 5, ?string $from = null): Collection
    {
        return $this->query()
            ->select('tours.*')
            ->withCount(['bookings' => fn ($q) => $q->revenueCounted()
                ->when($from, fn ($sub) => $sub->whereDate('created_at', '>=', $from))])
            ->withSum(['bookings' => fn ($q) => $q->revenueCounted()
                ->when($from, fn ($sub) => $sub->whereDate('created_at', '>=', $from))], 'grand_total')
            ->orderByDesc('bookings_count')
            ->limit($limit)
            ->get();
    }

    public function recalculateRating(Tour $tour): void
    {
        $stats = $tour->approvedReviews()
            ->selectRaw('COUNT(*) as total, COALESCE(AVG(rating), 0) as avg_rating')
            ->first();

        $tour->forceFill([
            'average_rating' => round((float) $stats->avg_rating, 2),
            'reviews_count'  => (int) $stats->total,
        ])->saveQuietly();
    }
}
