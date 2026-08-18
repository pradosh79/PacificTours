<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\SeoMeta;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSeoMeta
{
    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function syncSeo(array $data): void
    {
        if (array_filter($data, static fn ($v) => filled($v)) === []) {
            return;
        }

        $this->seo()->updateOrCreate([], $data);
    }
}
