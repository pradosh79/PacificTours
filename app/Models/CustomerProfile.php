<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerProfile extends Model
{
    protected $fillable = [
        'user_id', 'date_of_birth', 'gender', 'address_line1', 'address_line2', 'city',
        'province', 'postal_code', 'country_id', 'passport_number', 'passport_expiry',
        'emergency_contact_name', 'emergency_contact_phone', 'newsletter_opt_in',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth'     => 'date',
            'passport_expiry'   => 'date',
            'newsletter_opt_in' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
