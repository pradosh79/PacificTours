<?php

declare(strict_types=1);

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'tour_id'        => ['required', 'exists:tours,id'],
            'booking_id'     => ['nullable', 'exists:bookings,id'],
            'rating'         => ['required', 'integer', 'between:1,5'],
            'rating_value'   => ['nullable', 'integer', 'between:1,5'],
            'rating_service' => ['nullable', 'integer', 'between:1,5'],
            'rating_guide'   => ['nullable', 'integer', 'between:1,5'],
            'title'          => ['nullable', 'string', 'max:200'],
            'comment'        => ['required', 'string', 'min:20', 'max:3000'],
            'images'         => ['nullable', 'array', 'max:5'],
            'images.*'       => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
