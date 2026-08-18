<?php

declare(strict_types=1);

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:160'],
            'email'   => ['required', 'email:rfc', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:32'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
            'website' => ['prohibited'],   // honeypot
        ];
    }
}
