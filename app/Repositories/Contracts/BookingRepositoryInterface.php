<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Booking;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BookingRepositoryInterface extends RepositoryInterface
{
    public function findByNumber(string $number): ?Booking;

    public function forUser(int $userId, array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function upcoming(int $limit = 5): Collection;

    public function recent(int $limit = 10): Collection;

    public function dashboardCounters(): array;

    public function monthlyRevenue(int $months = 12): array;

    public function monthlyBookings(int $months = 12): array;
}
