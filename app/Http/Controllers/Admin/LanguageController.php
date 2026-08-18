<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class LanguageController extends CrudController
{
    protected string $model = Language::class;

    protected string $viewPath = 'admin.settings.languages';

    protected string $routeName = 'admin.languages';

    protected string $permission = 'setting';

    protected array $searchable = ['name', 'code'];

    protected array $columns = ['name' => 'Language', 'code' => 'Code', 'direction' => 'Direction'];

    protected string $title = 'Languages';

    protected function rules(?Model $record = null): array
    {
        return [
            'name'       => ['required', 'string', 'max:80'],
            'code'       => ['required', 'string', 'max:5', Rule::unique('languages', 'code')->ignore($record?->id)],
            'direction'  => ['required', 'in:ltr,rtl'],
            'is_default' => ['boolean'],
            'is_active'  => ['boolean'],
        ];
    }

    protected function prepare(array $data): array
    {
        if (! empty($data['is_default'])) {
            Language::where('is_default', true)->update(['is_default' => false]);
            $data['is_active'] = true;
        }

        return $data;
    }
}
