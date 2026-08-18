<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Booking::class);
    }

    public function rules(): array
    {
        return [
            'tour_id'             => ['required', 'exists:tours,id'],
            'tour_departure_id'   => ['nullable', 'exists:tour_departures,id'],
            'user_id'             => ['nullable', 'exists:users,id'],
            'travel_date'         => ['required', 'date', 'after_or_equal:today'],
            'adults'              => ['required', 'integer', 'min:1', 'max:50'],
            'children'            => ['nullable', 'integer', 'min:0', 'max:50'],
            'infants'             => ['nullable', 'integer', 'min:0', 'max:20'],
            'customer_first_name' => ['required', 'string', 'max:100'],
            'customer_last_name'  => ['nullable', 'string', 'max:100'],
            'customer_email'      => ['required', 'email:rfc,dns', 'max:255'],
            'customer_phone'      => ['nullable', 'string', 'max:32'],
            'coupon_code'         => ['nullable', 'string', 'max:40'],
            'customer_note'       => ['nullable', 'string', 'max:2000'],
            'admin_note'          => ['nullable', 'string', 'max:2000'],
            'travelers'           => ['nullable', 'array'],
            'travelers.*.type'    => ['required', 'in:adult,child,infant'],
            'travelers.*.first_name' => ['required', 'string', 'max:100'],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated(), ['source' => 'admin', 'ip_address' => $this->ip()]);
    }
}
