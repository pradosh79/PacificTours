<?php

declare(strict_types=1);

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'      => ['required', 'string', 'max:100'],
            'last_name'       => ['nullable', 'string', 'max:100'],
            'email'           => ['required', 'email:rfc', Rule::unique('users')->ignore($this->user()->id)],
            'phone'           => ['nullable', 'string', 'max:32'],
            'avatar'          => ['nullable', 'image', 'max:2048'],
            'locale'          => ['nullable', 'string', 'max:5'],
            'profile.date_of_birth'          => ['nullable', 'date', 'before:today'],
            'profile.gender'                 => ['nullable', 'in:male,female,other,prefer_not_to_say'],
            'profile.address_line1'          => ['nullable', 'string', 'max:255'],
            'profile.city'                   => ['nullable', 'string', 'max:120'],
            'profile.province'               => ['nullable', 'string', 'max:120'],
            'profile.postal_code'            => ['nullable', 'string', 'max:20'],
            'profile.country_id'             => ['nullable', 'exists:countries,id'],
            'profile.passport_number'        => ['nullable', 'string', 'max:64'],
            'profile.passport_expiry'        => ['nullable', 'date'],
            'profile.emergency_contact_name' => ['nullable', 'string', 'max:160'],
            'profile.emergency_contact_phone'=> ['nullable', 'string', 'max:32'],
            'profile.newsletter_opt_in'      => ['boolean'],
        ];
    }
}
