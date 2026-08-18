<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BannerType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'type', 'title', 'subtitle', 'image', 'mobile_image', 'button_text',
        'button_url', 'starts_at', 'ends_at', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['type' => BannerType::class, 'starts_at' => 'datetime', 'ends_at' => 'datetime', 'is_active' => 'boolean'];
    }

    public function scopeLive(Builder $q): Builder
    {
        return $q->where('is_active', true)
            ->where(fn ($s) => $s->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn ($s) => $s->whereNull('ends_at')->orWhere('ends_at', '>=', now()))
            ->orderBy('sort_order');
    }
}
