<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FlashSale extends Model
{
    protected $fillable = ['title', 'discount_type', 'discount_value', 'starts_at', 'ends_at', 'is_active'];

    protected function casts(): array
    {
        return [
            'discount_type' => DiscountType::class,
            'starts_at'     => 'datetime',
            'ends_at'       => 'datetime',
            'is_active'     => 'boolean',
        ];
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class);
    }

    public function scopeRunning(Builder $q): Builder
    {
        return $q->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }
}
