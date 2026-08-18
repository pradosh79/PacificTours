<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Tour;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TourRepositoryInterface extends RepositoryInterface
{
    public function search(array $filters, int $perPage = 12): LengthAwarePaginator;

    public function findBySlug(string $slug): ?Tour;

    public function featured(int $limit = 8): Collection;

    public function popular(int $limit = 8): Collection;

    public function related(Tour $tour, int $limit = 4): Collection;

    public function topSelling(int $limit = 5, ?string $from = null): Collection;

    public function recalculateRating(Tour $tour): void;
}
