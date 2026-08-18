<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasSeoMeta;
use App\Traits\HasSlug;
use App\Traits\HasUuid;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasSeoMeta;
    use HasSlug;
    use HasUuid;
    use SoftDeletes;
    use Translatable;

    protected $fillable = [
        'uuid', 'title', 'slug', 'template', 'content', 'sections', 'banner',
        'is_system', 'show_in_footer', 'status', 'updated_by',
    ];

    protected function casts(): array
    {
        return ['sections' => 'array', 'is_system' => 'boolean', 'show_in_footer' => 'boolean'];
    }

    public function scopePublished($q)
    {
        return $q->where('status', 'published');
    }
}
