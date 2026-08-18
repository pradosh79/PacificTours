<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class PostCategoryController extends CrudController
{
    protected string $model = PostCategory::class;

    protected string $viewPath = 'admin.cms.post-categories';

    protected string $routeName = 'admin.post-categories';

    protected string $permission = 'cms';

    protected array $searchable = ['name', 'slug'];

    protected array $columns = ['name' => 'Name', 'slug' => 'Slug'];

    protected string $title = 'Blog categories';

    protected function rules(?Model $record = null): array
    {
        return [
            'name'      => ['required', 'string', 'max:160'],
            'slug'      => ['nullable', 'string', Rule::unique('post_categories', 'slug')->ignore($record?->id)],
            'is_active' => ['boolean'],
        ];
    }
}
