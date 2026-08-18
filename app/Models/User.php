<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RoleName;
use App\Enums\UserStatus;
use App\Traits\HasUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use HasUuid;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'first_name', 'last_name', 'email', 'phone', 'password', 'avatar',
        'status', 'locale', 'timezone', 'created_by', 'email_verified_at',
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'       => 'datetime',
            'phone_verified_at'       => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'last_login_at'           => 'datetime',
            'password'                => 'hashed',
            'status'                  => UserStatus::class,
        ];
    }

    // ---------------------------------------------------------------- relations

    public function profile(): HasOne
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // ------------------------------------------------------------------ helpers

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function isStaff(): bool
    {
        return $this->hasAnyRole(RoleName::staff());
    }

    public function isCustomer(): bool
    {
        return $this->hasRole(RoleName::Customer->value);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleName::SuperAdmin->value);
    }

    public function scopeCustomers($query)
    {
        return $query->role(RoleName::Customer->value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', UserStatus::Active->value);
    }
}
