<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasSeoMeta;
use App\Traits\HasSlug;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourCategory extends Model
{
    use HasSeoMeta;
    use HasSlug;
    use SoftDeletes;
    use Translatable;

    protected $fillable = [
        'parent_id', 'name', 'slug', 'icon', 'image', 'description',
        'show_in_menu', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'show_in_menu' => 'boolean'];
    }

    protected function slugSource(): string
    {
        return 'name';
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
}
