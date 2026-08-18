<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TravelerType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingTraveler extends Model
{
    protected $fillable = [
        'booking_id', 'type', 'first_name', 'last_name', 'date_of_birth', 'gender',
        'nationality', 'passport_number', 'passport_expiry', 'dietary_requirement', 'special_request',
    ];

    protected function casts(): array
    {
        return [
            'type'            => TravelerType::class,
            'date_of_birth'   => 'date',
            'passport_expiry' => 'date',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
