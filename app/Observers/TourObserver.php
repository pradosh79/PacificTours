<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Tour;
use App\Services\MediaService;
use Illuminate\Support\Facades\Cache;

class TourObserver
{
    public function __construct(private readonly MediaService $media) {}

    public function saved(Tour $tour): void
    {
        Cache::forget('search:facets');
        Cache::forget('home:payload');
    }

    public function deleted(Tour $tour): void
    {
        Cache::forget('search:facets');
    }

    /** Only hard deletes clear storage — soft-deleted tours keep their media. */
    public function forceDeleted(Tour $tour): void
    {
        $this->media->delete($tour->thumbnail);
        $this->media->delete($tour->banner);

        $tour->images->each(fn ($image) => $this->media->delete($image->path));
    }
}
