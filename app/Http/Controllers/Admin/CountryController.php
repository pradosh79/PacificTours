<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class CountryController extends CrudController
{
    protected string $model = Country::class;

    protected string $viewPath = 'admin.cms.countries';

    protected string $routeName = 'admin.countries';

    protected string $permission = 'destination';

    protected array $searchable = ['name', 'iso2', 'iso3'];

    protected array $columns = ['name' => 'Country', 'iso2' => 'ISO', 'phone_code' => 'Dial code', 'currency_code' => 'Currency'];

    protected string $title = 'Countries';

    protected function rules(?Model $record = null): array
    {
        return [
            'name'          => ['required', 'string', 'max:120'],
            'iso2'          => ['required', 'string', 'size:2', Rule::unique('countries', 'iso2')->ignore($record?->id)],
            'iso3'          => ['nullable', 'string', 'size:3'],
            'phone_code'    => ['nullable', 'string', 'max:8'],
            'currency_code' => ['nullable', 'string', 'size:3'],
            'is_active'     => ['boolean'],
        ];
    }

    protected function prepare(array $data): array
    {
        $data['iso2'] = strtoupper($data['iso2']);
        $data['iso3'] = isset($data['iso3']) ? strtoupper($data['iso3']) : null;

        return $data;
    }
}
