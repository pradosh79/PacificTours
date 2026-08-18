<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = ['area', 'type', 'title', 'content', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['content' => 'array', 'is_active' => 'boolean'];
    }

    public function scopeArea($q, string $area)
    {
        return $q->where('area', $area)->where('is_active', true)->orderBy('sort_order');
    }
}
