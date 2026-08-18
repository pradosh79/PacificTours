<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'slug', 'is_active'];

    protected function slugSource(): string
    {
        return 'name';
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
