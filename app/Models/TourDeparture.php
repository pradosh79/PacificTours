<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Inventory unit. Seats are held here, never on the tour, so the same tour can
 * run on many dates with independent capacity and pricing.
 */
class TourDeparture extends Model
{
    use HasUuid;

    protected $fillable = [
        'uuid', 'tour_id', 'start_date', 'end_date', 'departure_time', 'price_override',
        'child_price_override', 'seats_total', 'seats_booked', 'seats_blocked', 'status',
        'guide_name', 'note',
    ];

    protected function casts(): array
    {
        return [
            'start_date'           => 'date',
            'end_date'             => 'date',
            'price_override'       => 'decimal:2',
            'child_price_override' => 'decimal:2',
        ];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getSeatsAvailableAttribute(): int
    {
        return max(0, $this->seats_total - $this->seats_booked - $this->seats_blocked);
    }

    public function canHold(int $seats): bool
    {
        return $this->status === 'open' && $this->seats_available >= $seats;
    }

    public function scopeOpen(Builder $q): Builder
    {
        return $q->where('status', 'open')
            ->whereDate('start_date', '>=', today())
            ->whereColumn('seats_booked', '<', 'seats_total');
    }
}
