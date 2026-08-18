<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class CurrencyController extends CrudController
{
    protected string $model = Currency::class;

    protected string $viewPath = 'admin.settings.currencies';

    protected string $routeName = 'admin.currencies';

    protected string $permission = 'setting';

    protected array $searchable = ['name', 'code'];

    protected array $columns = ['name' => 'Currency', 'code' => 'Code', 'symbol' => 'Symbol', 'exchange_rate' => 'Rate'];

    protected string $title = 'Currencies';

    protected function rules(?Model $record = null): array
    {
        return [
            'name'          => ['required', 'string', 'max:80'],
            'code'          => ['required', 'string', 'size:3', Rule::unique('currencies', 'code')->ignore($record?->id)],
            'symbol'        => ['required', 'string', 'max:8'],
            'exchange_rate' => ['required', 'numeric', 'min:0.000001'],
            'is_default'    => ['boolean'],
            'is_active'     => ['boolean'],
        ];
    }

    protected function prepare(array $data): array
    {
        $data['code'] = strtoupper($data['code']);

        app(CurrencyService::class)->flush();

        // Exactly one default currency, always.
        if (! empty($data['is_default'])) {
            Currency::where('is_default', true)->update(['is_default' => false]);
            $data['exchange_rate'] = 1;
        }

        return $data;
    }
}
