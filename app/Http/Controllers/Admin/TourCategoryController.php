<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\TourCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class TourCategoryController extends CrudController
{
    protected string $model = TourCategory::class;

    protected string $viewPath = 'admin.cms.categories';

    protected string $routeName = 'admin.categories';

    protected string $permission = 'category';

    protected array $searchable = ['name', 'slug'];

    protected array $relations = ['parent:id,name'];

    protected function rules(?Model $record = null): array
    {
        return [
            'parent_id'    => ['nullable', 'exists:tour_categories,id'],
            'name'         => ['required', 'string', 'max:160'],
            'slug'         => ['nullable', 'string', Rule::unique('tour_categories', 'slug')->ignore($record?->id)],
            'icon'         => ['nullable', 'string', 'max:80'],
            'description'  => ['nullable', 'string'],
            'show_in_menu' => ['boolean'],
            'sort_order'   => ['nullable', 'integer'],
            'is_active'    => ['boolean'],
        ];
    }
}
