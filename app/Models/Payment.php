<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentGateway;
use App\Enums\PaymentType;
use App\Enums\TransactionStatus;
use App\Traits\HasUuid;
use App\Traits\MoneyFormat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasUuid;
    use MoneyFormat;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'booking_id', 'invoice_id', 'user_id', 'gateway', 'type', 'transaction_id',
        'gateway_reference', 'amount', 'gateway_fee', 'currency', 'exchange_rate', 'status',
        'gateway_payload', 'failure_reason', 'paid_at', 'ip_address',
    ];

    protected $hidden = ['gateway_payload'];

    protected function casts(): array
    {
        return [
            'gateway'         => PaymentGateway::class,
            'type'            => PaymentType::class,
            'status'          => TransactionStatus::class,
            'gateway_payload' => 'encrypted:array',
            'paid_at'         => 'datetime',
            'amount'          => 'decimal:2',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Alias for admin views: the staff member who recorded a manual payment. */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    public function scopeSucceeded(Builder $q): Builder
    {
        return $q->where('status', TransactionStatus::Succeeded->value);
    }

    public function getRefundableAmountAttribute(): float
    {
        return round((float) $this->amount - (float) $this->refunds()->where('status', 'completed')->sum('amount'), 2);
    }
}
