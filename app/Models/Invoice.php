<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\MoneyFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasUuid;
    use MoneyFormat;

    protected $fillable = [
        'uuid', 'invoice_number', 'booking_id', 'issued_at', 'due_at', 'subtotal',
        'discount_total', 'tax_total', 'total', 'amount_paid', 'currency', 'status',
        'pdf_path', 'billing_snapshot',
    ];

    protected function casts(): array
    {
        return [
            'issued_at'        => 'date',
            'due_at'           => 'date',
            'billing_snapshot' => 'array',
            'total'            => 'decimal:2',
            'amount_paid'      => 'decimal:2',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getBalanceAttribute(): float
    {
        return round((float) $this->total - (float) $this->amount_paid, 2);
    }
}
