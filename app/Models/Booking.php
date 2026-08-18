<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Traits\Filterable;
use App\Traits\HasUuid;
use App\Traits\MoneyFormat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use Filterable;
    use HasFactory;
    use HasUuid;
    use MoneyFormat;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'booking_number', 'tour_id', 'tour_departure_id', 'user_id',
        'customer_first_name', 'customer_last_name', 'customer_email', 'customer_phone',
        'customer_country', 'customer_address', 'travel_date', 'return_date',
        'adults', 'children', 'infants', 'adult_unit_price', 'child_unit_price', 'infant_unit_price',
        'subtotal', 'tour_discount', 'coupon_discount', 'service_fee', 'tax_total', 'grand_total',
        'deposit_amount', 'paid_amount', 'due_amount', 'refunded_amount', 'currency', 'coupon_id',
        'status', 'payment_status', 'source', 'customer_note', 'admin_note', 'meta',
        'confirmed_at', 'cancelled_at', 'completed_at', 'cancellation_reason', 'ip_address', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'status'          => BookingStatus::class,
            'payment_status'  => PaymentStatus::class,
            'travel_date'     => 'date',
            'return_date'     => 'date',
            'confirmed_at'    => 'datetime',
            'cancelled_at'    => 'datetime',
            'completed_at'    => 'datetime',
            'meta'            => 'array',
            'subtotal'        => 'decimal:2',
            'grand_total'     => 'decimal:2',
            'paid_amount'     => 'decimal:2',
            'due_amount'      => 'decimal:2',
            'deposit_amount'  => 'decimal:2',
            'coupon_discount' => 'decimal:2',
            'tour_discount'   => 'decimal:2',
            'tax_total'       => 'decimal:2',
        ];
    }

    // ---------------------------------------------------------------- relations

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function departure(): BelongsTo
    {
        return $this->belongsTo(TourDeparture::class, 'tour_departure_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function travelers(): HasMany
    {
        return $this->hasMany(BookingTraveler::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(BookingStatusHistory::class)->latest('id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function successfulPayments(): HasMany
    {
        return $this->payments()->where('status', 'succeeded');
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    // ------------------------------------------------------------------- scopes

    public function scopeToday(Builder $q): Builder
    {
        return $q->whereDate('created_at', today());
    }

    public function scopePending(Builder $q): Builder
    {
        return $q->where('status', BookingStatus::Pending->value);
    }

    public function scopeUpcoming(Builder $q): Builder
    {
        return $q->whereDate('travel_date', '>=', today())
            ->whereIn('status', [BookingStatus::Pending->value, BookingStatus::Confirmed->value]);
    }

    public function scopeRevenueCounted(Builder $q): Builder
    {
        return $q->whereIn('status', [BookingStatus::Confirmed->value, BookingStatus::Completed->value]);
    }

    // ------------------------------------------------------------------ filters

    protected function filterKeyword(Builder $q, string $v): void
    {
        $q->where(fn ($s) => $s->where('booking_number', 'like', "%{$v}%")
            ->orWhere('customer_email', 'like', "%{$v}%")
            ->orWhere('customer_first_name', 'like', "%{$v}%")
            ->orWhere('customer_last_name', 'like', "%{$v}%"));
    }

    protected function filterStatus(Builder $q, mixed $v): void
    {
        $q->whereIn('status', (array) $v);
    }

    protected function filterPaymentStatus(Builder $q, mixed $v): void
    {
        $q->whereIn('payment_status', (array) $v);
    }

    protected function filterTourId(Builder $q, mixed $v): void
    {
        $q->where('tour_id', $v);
    }

    protected function filterDateFrom(Builder $q, mixed $v): void
    {
        $q->whereDate('created_at', '>=', $v);
    }

    protected function filterDateTo(Builder $q, mixed $v): void
    {
        $q->whereDate('created_at', '<=', $v);
    }

    protected function filterTravelFrom(Builder $q, mixed $v): void
    {
        $q->whereDate('travel_date', '>=', $v);
    }

    protected function filterTravelTo(Builder $q, mixed $v): void
    {
        $q->whereDate('travel_date', '<=', $v);
    }

    // ------------------------------------------------------------------ helpers

    public function getCustomerNameAttribute(): string
    {
        return trim($this->customer_first_name.' '.$this->customer_last_name);
    }

    public function getTotalGuestsAttribute(): int
    {
        return $this->adults + $this->children + $this->infants;
    }

    /** Seats consumed against departure inventory (infants ride free / on lap). */
    public function seatCount(): int
    {
        return $this->adults + $this->children;
    }

    public function isFullyPaid(): bool
    {
        return (float) $this->due_amount <= 0.009;
    }

    public function isCancellable(): bool
    {
        return $this->status->canTransitionTo(BookingStatus::Cancelled);
    }
}
