<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class CouponController extends CrudController
{
    protected string $model = Coupon::class;

    protected string $viewPath = 'admin.cms.coupons';

    protected string $routeName = 'admin.coupons';

    protected string $permission = 'coupon';

    protected array $searchable = ['code', 'name'];

    protected function rules(?Model $record = null): array
    {
        return [
            'code'                   => ['required', 'string', 'max:40', Rule::unique('coupons', 'code')->ignore($record?->id)],
            'name'                   => ['nullable', 'string', 'max:160'],
            'type'                   => ['required', 'in:percentage,fixed'],
            'value'                  => ['required', 'numeric', 'min:0'],
            'min_spend'              => ['nullable', 'numeric', 'min:0'],
            'max_discount'           => ['nullable', 'numeric', 'min:0'],
            'usage_limit'            => ['nullable', 'integer', 'min:1'],
            'usage_limit_per_user'   => ['required', 'integer', 'min:1'],
            'applicable_tour_ids'    => ['nullable', 'array'],
            'applicable_category_ids'=> ['nullable', 'array'],
            'starts_at'              => ['nullable', 'date'],
            'expires_at'             => ['nullable', 'date', 'after:starts_at'],
            'is_active'              => ['boolean'],
        ];
    }

    protected function prepare(array $data): array
    {
        $data['code']       = strtoupper($data['code']);
        $data['created_by'] = auth()->id();

        return $data;
    }
}
