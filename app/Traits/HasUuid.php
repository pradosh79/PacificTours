<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Adds a public, non-guessable UUID alongside the auto-increment primary key.
 * Internal joins stay on BIGINT; every public URL / API payload exposes the UUID.
 */
trait HasUuid
{
    public static function bootHasUuid(): void
    {
        static::creating(function (Model $model): void {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function scopeUuid($query, string $uuid)
    {
        return $query->where('uuid', $uuid);
    }
}
