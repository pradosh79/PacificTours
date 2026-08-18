<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReviewStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'tour_id', 'user_id', 'booking_id', 'reviewer_name', 'rating', 'rating_value',
        'rating_service', 'rating_guide', 'title', 'comment', 'status', 'admin_reply',
        'approved_by', 'approved_at', 'is_verified_purchase',
    ];

    protected function casts(): array
    {
        return [
            'status'               => ReviewStatus::class,
            'approved_at'          => 'datetime',
            'is_verified_purchase' => 'boolean',
        ];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ReviewImage::class);
    }

    public function scopeApproved(Builder $q): Builder
    {
        return $q->where('status', ReviewStatus::Approved->value);
    }
}
