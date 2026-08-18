<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateTourRequest extends StoreTourRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('tour'));
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'slug' => ['nullable', 'string', 'max:220', Rule::unique('tours', 'slug')->ignore($this->route('tour')->id)],
        ]);
    }
}
