<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = ['email', 'name', 'token', 'verified_at', 'unsubscribed_at', 'ip_address'];

    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'unsubscribed_at' => 'datetime'];
    }

    public function scopeActive($q)
    {
        return $q->whereNull('unsubscribed_at');
    }
}
