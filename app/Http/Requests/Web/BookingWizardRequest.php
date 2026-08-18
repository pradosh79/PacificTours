<?php

declare(strict_types=1);

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates the whole wizard payload in one pass at submit time; each step is
 * additionally validated client-side by Alpine before it advances.
 */
class BookingWizardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;   // guest checkout allowed
    }

    public function rules(): array
    {
        return [
            'tour_id'           => ['required', 'exists:tours,id'],
            'tour_departure_id' => ['nullable', 'exists:tour_departures,id'],
            'travel_date'       => ['required', 'date', 'after_or_equal:today'],

            'adults'            => ['required', 'integer', 'min:1', 'max:30'],
            'children'          => ['nullable', 'integer', 'min:0', 'max:30'],
            'infants'           => ['nullable', 'integer', 'min:0', 'max:10'],

            'customer_first_name' => ['required', 'string', 'max:100'],
            'customer_last_name'  => ['nullable', 'string', 'max:100'],
            'customer_email'      => ['required', 'email:rfc', 'max:255'],
            'customer_phone'      => ['required', 'string', 'max:32'],
            'customer_country'    => ['nullable', 'string', 'max:120'],
            'customer_address'    => ['nullable', 'string', 'max:255'],

            'travelers'                     => ['nullable', 'array', 'max:60'],
            'travelers.*.type'              => ['required', 'in:adult,child,infant'],
            'travelers.*.first_name'        => ['required', 'string', 'max:100'],
            'travelers.*.last_name'         => ['nullable', 'string', 'max:100'],
            'travelers.*.date_of_birth'     => ['nullable', 'date', 'before:today'],
            'travelers.*.passport_number'   => ['nullable', 'string', 'max:64'],
            'travelers.*.passport_expiry'   => ['nullable', 'date', 'after:travel_date'],
            'travelers.*.special_request'   => ['nullable', 'string', 'max:500'],

            'coupon_code'   => ['nullable', 'string', 'max:40'],
            'customer_note' => ['nullable', 'string', 'max:2000'],
            'pay_deposit'   => ['boolean'],
            'gateway'       => ['required', 'string', 'in:stripe,paypal,bank_transfer'],
            'terms'         => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'terms.accepted'            => 'Please accept the booking terms to continue.',
            'travelers.*.passport_expiry.after' => 'Passports must be valid on the travel date.',
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return array_merge(parent::validated(), [
            'user_id'    => $this->user()?->id,
            'source'     => 'web',
            'ip_address' => $this->ip(),
        ]);
    }
}
