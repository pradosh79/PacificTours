<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookingRepository extends BaseRepository implements BookingRepositoryInterface
{
    public function __construct(Booking $model)
    {
        parent::__construct($model);
    }

    public function findByNumber(string $number): ?Booking
    {
        return $this->query()->with(['tour', 'travelers', 'payments', 'invoice'])
            ->where('booking_number', $number)->first();
    }

    public function forUser(int $userId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->query()
            ->where('user_id', $userId)
            ->with(['tour:id,title,slug,thumbnail,duration_days', 'invoice'])
            ->filter($filters)
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function upcoming(int $limit = 5): Collection
    {
        return $this->query()->upcoming()->with('tour:id,title,slug')
            ->orderBy('travel_date')->limit($limit)->get();
    }

    public function recent(int $limit = 10): Collection
    {
        return $this->query()->with(['tour:id,title,slug', 'user:id,first_name,last_name'])
            ->latest('id')->limit($limit)->get();
    }

    /** Single round-trip for the six dashboard counters. */
    public function dashboardCounters(): array
    {
        $row = $this->query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN DATE(created_at) = ? THEN 1 ELSE 0 END) as today', [today()->toDateString()])
            ->selectRaw('SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as pending', [BookingStatus::Pending->value])
            ->selectRaw('SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as confirmed', [BookingStatus::Confirmed->value])
            ->selectRaw('SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as completed', [BookingStatus::Completed->value])
            ->selectRaw('SUM(CASE WHEN status IN (?, ?) THEN grand_total ELSE 0 END) as revenue', [
                BookingStatus::Confirmed->value, BookingStatus::Completed->value,
            ])
            ->selectRaw('SUM(paid_amount) as collected')
            ->first();

        return [
            'total'     => (int) $row->total,
            'today'     => (int) $row->today,
            'pending'   => (int) $row->pending,
            'confirmed' => (int) $row->confirmed,
            'completed' => (int) $row->completed,
            'revenue'   => (float) $row->revenue,
            'collected' => (float) $row->collected,
        ];
    }

    public function monthlyRevenue(int $months = 12): array
    {
        return $this->query()
            ->revenueCounted()
            ->where('created_at', '>=', now()->subMonths($months)->startOfMonth())
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as period"), DB::raw('SUM(grand_total) as total'))
            ->groupBy('period')->orderBy('period')
            ->pluck('total', 'period')->toArray();
    }

    public function monthlyBookings(int $months = 12): array
    {
        return $this->query()
            ->where('created_at', '>=', now()->subMonths($months)->startOfMonth())
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as period"), DB::raw('COUNT(*) as total'))
            ->groupBy('period')->orderBy('period')
            ->pluck('total', 'period')->toArray();
    }
}
