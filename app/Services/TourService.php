<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tour;
use App\Repositories\Contracts\TourRepositoryInterface;
use App\Support\NumberGenerator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Write-side orchestration for the tour catalogue: the tour row plus its six
 * child collections are saved in one transaction so a half-built itinerary can
 * never be published.
 */
class TourService
{
    public function __construct(
        private readonly TourRepositoryInterface $tours,
        private readonly MediaService $media,
        private readonly PricingService $pricing,
    ) {}

    public function create(array $data): Tour
    {
        return DB::transaction(function () use ($data): Tour {
            $tour = $this->tours->create(array_merge(
                $this->columns($data),
                ['code' => NumberGenerator::tourCode(), 'created_by' => auth()->id()]
            ));

            $this->syncChildren($tour, $data);
            $this->pricing->refreshSalePrice($tour);
            $tour->syncSeo($data['seo'] ?? []);
            $this->flushCaches();

            return $tour->refresh();
        });
    }

    public function update(Tour $tour, array $data): Tour
    {
        return DB::transaction(function () use ($tour, $data): Tour {
            $this->tours->update($tour, array_merge($this->columns($data), ['updated_by' => auth()->id()]));

            $this->syncChildren($tour, $data, replace: true);
            $this->pricing->refreshSalePrice($tour);
            $tour->syncSeo($data['seo'] ?? []);
            $this->flushCaches();

            return $tour->refresh();
        });
    }

    public function duplicate(Tour $tour): Tour
    {
        return DB::transaction(function () use ($tour): Tour {
            $copy = $tour->replicate(['uuid', 'code', 'slug', 'bookings_count', 'reviews_count', 'average_rating']);
            $copy->title  = $tour->title.' (copy)';
            $copy->slug   = null;
            $copy->code   = NumberGenerator::tourCode();
            $copy->status = \App\Enums\TourStatus::Draft;
            $copy->save();

            foreach (['images', 'itineraries', 'inclusions', 'highlights', 'faqs'] as $relation) {
                foreach ($tour->{$relation} as $child) {
                    $copy->{$relation}()->create($child->only($child->getFillable()));
                }
            }

            return $copy;
        });
    }

    public function toggle(Tour $tour, string $flag): Tour
    {
        abort_unless(in_array($flag, ['is_featured', 'is_popular', 'is_recommended'], true), 400);

        $tour->update([$flag => ! $tour->{$flag}]);
        $this->flushCaches();

        return $tour;
    }

    private function columns(array $data): array
    {
        $columns = collect($data)->except(['seo', 'images', 'itineraries', 'included', 'excluded', 'highlights', 'faqs', 'departures', 'tags'])->toArray();

        foreach (['thumbnail', 'banner'] as $field) {
            if (($data[$field] ?? null) instanceof UploadedFile) {
                $columns[$field] = $this->media->store($data[$field], 'tours');
            }
        }

        return $columns;
    }

    private function syncChildren(Tour $tour, array $data, bool $replace = false): void
    {
        if (isset($data['images'])) {
            foreach ($data['images'] as $i => $image) {
                $tour->images()->create([
                    'path'       => $image instanceof UploadedFile ? $this->media->store($image, 'tours/gallery') : $image,
                    'sort_order' => $i,
                ]);
            }
        }

        $map = [
            'itineraries' => fn (array $row, int $i) => array_merge($row, ['sort_order' => $i]),
            'highlights'  => fn (array $row, int $i) => ['content' => $row['content'], 'icon' => $row['icon'] ?? null, 'sort_order' => $i],
            'faqs'        => fn (array $row, int $i) => ['question' => $row['question'], 'answer' => $row['answer'], 'sort_order' => $i],
            'departures'  => fn (array $row, int $i) => $row,
        ];

        foreach ($map as $relation => $transform) {
            if (! isset($data[$relation])) {
                continue;
            }

            if ($replace && $relation !== 'departures') {
                $tour->{$relation}()->delete();
            }

            foreach (array_values($data[$relation]) as $i => $row) {
                $tour->{$relation}()->create($transform($row, $i));
            }
        }

        foreach (['included', 'excluded'] as $type) {
            if (! isset($data[$type])) {
                continue;
            }

            if ($replace) {
                $tour->inclusions()->where('type', $type)->delete();
            }

            foreach (array_values(array_filter($data[$type])) as $i => $content) {
                $tour->inclusions()->create(['type' => $type, 'content' => $content, 'sort_order' => $i]);
            }
        }

        if (isset($data['tags'])) {
            $tour->tags()->sync($data['tags']);
        }
    }

    private function flushCaches(): void
    {
        Cache::forget('tours:featured:8');
        Cache::forget('tours:popular:8');
        Cache::forget('home:payload');
    }
}
