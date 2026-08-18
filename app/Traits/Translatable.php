<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Locale-aware attribute reads backed by the generic `translations` table.
 * Falls back to the base column when no translation row exists.
 */
trait Translatable
{
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function t(string $field, ?string $locale = null): mixed
    {
        $locale ??= app()->getLocale();

        if ($locale === config('app.fallback_locale')) {
            return $this->{$field};
        }

        $value = $this->relationLoaded('translations')
            ? optional($this->translations->firstWhere(fn ($t) => $t->locale === $locale && $t->field === $field))->value
            : $this->translations()->where('locale', $locale)->where('field', $field)->value('value');

        return filled($value) ? $value : $this->{$field};
    }

    public function setTranslation(string $locale, string $field, ?string $value): void
    {
        $this->translations()->updateOrCreate(compact('locale', 'field'), ['value' => $value]);
    }
}
