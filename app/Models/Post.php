<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PostType;
use App\Traits\HasSeoMeta;
use App\Traits\HasSlug;
use App\Traits\HasUuid;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasSeoMeta;
    use HasSlug;
    use HasUuid;
    use SoftDeletes;
    use Translatable;

    protected $fillable = [
        'uuid', 'type', 'post_category_id', 'author_id', 'title', 'slug', 'excerpt',
        'content', 'thumbnail', 'banner', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return ['type' => PostType::class, 'published_at' => 'datetime'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', 'published')->where('published_at', '<=', now());
    }

    public function scopeType(Builder $q, PostType $type): Builder
    {
        return $q->where('type', $type->value);
    }
}
