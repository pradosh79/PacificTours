<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\DepositType;
use App\Enums\DiscountType;
use App\Enums\TourStatus;
use App\Models\Tour;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Tour::class);
    }

    /**
     * Fill in sensible defaults for fields the admin form may not expose yet.
     * The tours table already defines matching column defaults, so this just
     * mirrors them at the request layer — otherwise "required" would fail
     * whenever the form is trimmed down (as the current tour form has been).
     *
     * On EDIT we default to the tour's already-stored value so an incomplete
     * form doesn't silently reset fields the admin never touched. On CREATE
     * we fall back to the same defaults the migration writes.
     */
    protected function prepareForValidation(): void
    {
        $existing = $this->route('tour');   // present on edit, null on create

        $this->mergeIfMissing([
            'tour_type'   => $existing?->tour_type   ?? 'group',
            'difficulty'  => $existing?->difficulty  ?? 'easy',
            'min_booking' => $existing?->min_booking ?? 1,
            'max_booking' => $existing?->max_booking ?? 12,
        ]);

        /*
         * NOT NULL money columns with a DB default of 0 must not receive NULL
         * from a blank form field. Laravel's ConvertEmptyStringsToNull middleware
         * turns "" into null, so we coerce those specific fields back to 0
         * whenever they're absent, empty, or explicitly null.
         */
        $moneyDefaults = [
            'discount_value' => 0,
            'deposit_value'  => 0,
            'tax_percentage' => 0,
            'service_fee'    => 0,
            'child_price'    => 0,
            'infant_price'   => 0,
        ];

        foreach ($moneyDefaults as $field => $default) {
            $value = $this->input($field);
            if ($value === null || $value === '') {
                $this->merge([$field => $default]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'title'                => ['required', 'string', 'max:200'],
            'slug'                 => ['nullable', 'string', 'max:220', Rule::unique('tours', 'slug')],
            'tour_category_id'     => ['required', 'exists:tour_categories,id'],
            'destination_id'       => ['nullable', 'exists:destinations,id'],
            'country_id'           => ['nullable', 'exists:countries,id'],
            'city_id'              => ['nullable', 'exists:cities,id'],
            'summary'              => ['nullable', 'string', 'max:500'],
            'description'          => ['nullable', 'string'],
            'travel_information'   => ['nullable', 'string'],
            'terms_and_conditions' => ['nullable', 'string'],
            'cancellation_policy'  => ['nullable', 'string'],
            'visa_requirements'    => ['nullable', 'string'],

            'duration_days'        => ['required', 'integer', 'min:1', 'max:365'],
            'duration_nights'      => ['required', 'integer', 'min:0', 'max:365'],
            'tour_type'            => ['nullable', Rule::in(['group', 'private', 'custom'])],
            'difficulty'           => ['nullable', Rule::in(['easy', 'moderate', 'challenging'])],
            'pickup_location'      => ['nullable', 'string', 'max:255'],
            'drop_location'        => ['nullable', 'string', 'max:255'],

            'base_price'           => ['required', 'numeric', 'min:0', 'max:9999999'],
            'child_price'          => ['nullable', 'numeric', 'min:0'],
            'infant_price'         => ['nullable', 'numeric', 'min:0'],
            'discount_type'        => ['required', Rule::enum(DiscountType::class)],
            'discount_value'       => ['nullable', 'numeric', 'min:0', 'required_unless:discount_type,none'],
            'tax_percentage'       => ['nullable', 'numeric', 'min:0', 'max:100'],
            'service_fee'          => ['nullable', 'numeric', 'min:0'],
            'deposit_type'         => ['required', Rule::enum(DepositType::class)],
            'deposit_value'        => ['nullable', 'numeric', 'min:0', 'required_unless:deposit_type,disabled'],

            'max_seats'            => ['required', 'integer', 'min:0'],
            'min_booking'          => ['nullable', 'integer', 'min:1'],
            'max_booking'          => ['nullable', 'integer', 'min:1', 'gte:min_booking'],
            'booking_cutoff_hours' => ['required', 'integer', 'min:0', 'max:8760'],

            'status'               => ['required', Rule::enum(TourStatus::class)],
            'is_featured'          => ['boolean'],
            'is_popular'           => ['boolean'],
            'is_recommended'       => ['boolean'],
            'published_at'         => ['nullable', 'date'],

            'thumbnail'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'banner'               => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'images'               => ['nullable', 'array', 'max:20'],
            'images.*'             => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'itineraries'                 => ['nullable', 'array'],
            'itineraries.*.day_number'    => ['required', 'integer', 'min:1'],
            'itineraries.*.title'         => ['required', 'string', 'max:200'],
            'itineraries.*.description'   => ['nullable', 'string'],
            'itineraries.*.accommodation' => ['nullable', 'string', 'max:200'],
            'itineraries.*.meals'         => ['nullable', 'string', 'max:120'],

            'included'             => ['nullable', 'array'],
            'included.*'           => ['nullable', 'string', 'max:255'],
            'excluded'             => ['nullable', 'array'],
            'excluded.*'           => ['nullable', 'string', 'max:255'],
            'highlights'           => ['nullable', 'array'],
            'highlights.*.content' => ['required', 'string', 'max:255'],
            'faqs'                 => ['nullable', 'array'],
            'faqs.*.question'      => ['required', 'string', 'max:255'],
            'faqs.*.answer'        => ['required', 'string'],

            'departures'                 => ['nullable', 'array'],
            'departures.*.start_date'    => ['required', 'date', 'after_or_equal:today'],
            'departures.*.end_date'      => ['nullable', 'date', 'after_or_equal:departures.*.start_date'],
            'departures.*.seats_total'   => ['required', 'integer', 'min:1'],
            'departures.*.price_override' => ['nullable', 'numeric', 'min:0'],

            'tags'                 => ['nullable', 'array'],
            'tags.*'               => ['exists:tags,id'],

            'seo.meta_title'       => ['nullable', 'string', 'max:200'],
            'seo.meta_description' => ['nullable', 'string', 'max:300'],
            'seo.og_image'         => ['nullable', 'string'],
            'seo.robots'           => ['nullable', 'string', 'max:60'],
        ];
    }

    public function messages(): array
    {
        return [
            'max_booking.gte'        => 'Maximum party size must be at least the minimum.',
            'discount_value.required_unless' => 'Enter a discount amount or set the discount type to none.',
        ];
    }
}
