<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasSeoMeta;
use App\Traits\HasSlug;
use App\Traits\HasUuid;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasSeoMeta;
    use HasSlug;
    use HasUuid;
    use SoftDeletes;
    use Translatable;

    protected $fillable = [
        'uuid', 'country_id', 'city_id', 'name', 'slug', 'short_description', 'description',
        'thumbnail', 'banner', 'best_time_to_visit', 'is_featured', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_featured' => 'boolean', 'is_active' => 'boolean'];
    }

    protected function slugSource(): string
    {
        return 'name';
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
