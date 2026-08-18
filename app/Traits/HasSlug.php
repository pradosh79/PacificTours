<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::saving(function (Model $model): void {
            $source = $model->slugSource();

            if (blank($model->slug) && filled($model->{$source})) {
                $model->slug = $model->generateUniqueSlug((string) $model->{$source});
            }
        });
    }

    protected function slugSource(): string
    {
        return 'title';
    }

    public function generateUniqueSlug(string $value): string
    {
        $base = Str::slug($value);
        $slug = $base;
        $i = 1;

        while (static::withoutGlobalScopes()->where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
