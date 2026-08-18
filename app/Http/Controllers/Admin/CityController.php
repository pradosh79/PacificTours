<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;

class CityController extends CrudController
{
    protected string $model = City::class;

    protected string $viewPath = 'admin.cms.cities';

    protected string $routeName = 'admin.cities';

    protected string $permission = 'destination';

    protected array $searchable = ['name', 'slug'];

    protected array $relations = ['country:id,name'];

    protected array $columns = ['name' => 'City', 'country.name' => 'Country'];

    protected string $title = 'Cities';

    protected function rules(?Model $record = null): array
    {
        return [
            'country_id' => ['required', 'exists:countries,id'],
            'name'       => ['required', 'string', 'max:160'],
            'latitude'   => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'  => ['nullable', 'numeric', 'between:-180,180'],
            'is_active'  => ['boolean'],
        ];
    }
}
