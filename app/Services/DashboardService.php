<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\TourRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookings,
        private readonly TourRepositoryInterface $tours,
        private readonly UserRepositoryInterface $users,
        private readonly PaymentRepositoryInterface $payments,
    ) {}

    public function payload(): array
    {
        return Cache::remember('admin:dashboard', now()->addMinutes(2), function (): array {
            $counters = $this->bookings->dashboardCounters();

            return [
                'cards' => [
                    'tours'             => $this->tours->query()->published()->count(),
                    'bookings'          => $counters['total'],
                    'bookings_today'    => $counters['today'],
                    'bookings_pending'  => $counters['pending'],
                    'tours_completed'   => $counters['completed'],
                    'revenue'           => $counters['revenue'],
                    'collected'         => $counters['collected'],
                    'customers'         => $this->users->query()->customers()->count(),
                ],
                'recent_bookings'  => $this->bookings->recent(8),
                'upcoming_tours'   => $this->bookings->upcoming(6),
                'recent_customers' => $this->users->recentCustomers(6),
                'latest_payments'  => $this->payments->latest(6),
                'charts' => [
                    'monthly_revenue'  => $this->bookings->monthlyRevenue(12),
                    'monthly_bookings' => $this->bookings->monthlyBookings(12),
                    'top_tours'        => $this->tours->topSelling(5)->map(fn ($t) => [
                        'title'    => $t->title,
                        'bookings' => $t->bookings_count,
                        'revenue'  => (float) $t->bookings_sum_grand_total,
                    ])->values(),
                ],
            ];
        });
    }

    public function flush(): void
    {
        Cache::forget('admin:dashboard');
    }
}
