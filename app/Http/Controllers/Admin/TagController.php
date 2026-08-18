<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class TagController extends CrudController
{
    protected string $model = Tag::class;

    protected string $viewPath = 'admin.cms.tags';

    protected string $routeName = 'admin.tags';

    protected string $permission = 'category';

    protected array $searchable = ['name', 'slug'];

    protected array $columns = ['name' => 'Name', 'slug' => 'Slug'];

    protected string $title = 'Tags';

    protected function rules(?Model $record = null): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', Rule::unique('tags', 'slug')->ignore($record?->id)],
        ];
    }
}
