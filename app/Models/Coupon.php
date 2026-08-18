<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'type', 'value', 'min_spend', 'max_discount', 'usage_limit',
        'usage_limit_per_user', 'used_count', 'applicable_tour_ids', 'applicable_category_ids',
        'starts_at', 'expires_at', 'is_active', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'type'                    => DiscountType::class,
            'applicable_tour_ids'     => 'array',
            'applicable_category_ids' => 'array',
            'starts_at'               => 'datetime',
            'expires_at'              => 'datetime',
            'is_active'               => 'boolean',
            'value'                   => 'decimal:2',
        ];
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeUsable(Builder $q): Builder
    {
        return $q->where('is_active', true)
            ->where(fn ($s) => $s->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn ($s) => $s->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
    }

    public function hasReachedGlobalLimit(): bool
    {
        return $this->usage_limit !== null && $this->used_count >= $this->usage_limit;
    }
}
