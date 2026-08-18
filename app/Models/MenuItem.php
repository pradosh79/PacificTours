<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id', 'parent_id', 'label', 'type', 'target_id', 'url', 'icon',
        'target', 'is_mega', 'mega_column', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_mega' => 'boolean', 'is_active' => 'boolean'];
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('is_active', true)->orderBy('sort_order');
    }

    /** Resolves the public URL for dynamic menu targets. */
    public function resolveUrl(): string
    {
        return match ($this->type) {
            'page'        => url('/page/'.optional(Page::find($this->target_id))->slug),
            'tour'        => url('/tours/'.optional(Tour::find($this->target_id))->slug),
            'category'    => url('/tours?category='.optional(TourCategory::find($this->target_id))->slug),
            'destination' => url('/destinations/'.optional(Destination::find($this->target_id))->slug),
            'blog'        => url('/blog'),
            default       => $this->url ?: '#',
        };
    }
}
