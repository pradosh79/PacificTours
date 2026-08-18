<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage-settings');
    }

    public function rules(): array
    {
        return match ($this->route('group')) {
            'general' => [
                'company_name'    => ['required', 'string', 'max:160'],
                'company_email'   => ['required', 'email'],
                'company_phone'   => ['nullable', 'string', 'max:32'],
                'company_address' => ['nullable', 'string', 'max:255'],
                'google_map'      => ['nullable', 'string'],
                'logo'            => ['nullable', 'image', 'max:2048'],
                'favicon'         => ['nullable', 'image', 'max:512'],
                'unpaid_booking_ttl_hours' => ['nullable', 'integer', 'min:1', 'max:720'],
            ],
            'smtp' => [
                'mail_host'       => ['required', 'string'],
                'mail_port'       => ['required', 'integer'],
                'mail_username'   => ['required', 'string'],
                'mail_password'   => ['nullable', 'string'],
                'mail_encryption' => ['required', Rule::in(['tls', 'ssl', 'none'])],
                'mail_from_name'  => ['required', 'string'],
                'mail_from_email' => ['required', 'email'],
            ],
            'payment' => [
                'stripe_enabled'        => ['boolean'],
                'stripe_key'            => ['nullable', 'string'],
                'stripe_secret'         => ['nullable', 'string'],
                'stripe_webhook_secret' => ['nullable', 'string'],
                'paypal_enabled'        => ['boolean'],
                'paypal_client_id'      => ['nullable', 'string'],
                'paypal_secret'         => ['nullable', 'string'],
            ],
            'theme' => [
                'currency' => ['required', 'string', 'size:3'],
                'timezone' => ['required', 'timezone'],
                'language' => ['required', 'string', 'max:5'],
            ],
            'home' => [
                // Hero
                'hero_title_lead'      => ['nullable', 'string', 'max:60'],
                'hero_title_accent'    => ['nullable', 'string', 'max:60'],
                'hero_title_trail'     => ['nullable', 'string', 'max:60'],
                'hero_subtitle'        => ['nullable', 'string', 'max:500'],
                'hero_cta_label'       => ['nullable', 'string', 'max:60'],
                'hero_bg'              => ['nullable', 'image', 'max:8192'],

                // Section intros
                'section_title'        => ['nullable', 'string', 'max:160'],
                'destinations_heading' => ['nullable', 'string', 'max:120'],
                'destinations_intro'   => ['nullable', 'string', 'max:1000'],
                'sprinter_image'       => ['nullable', 'image', 'max:6144'],
                'featured_heading'     => ['nullable', 'string', 'max:120'],
                'featured_intro'       => ['nullable', 'string', 'max:1000'],
                'why_heading'          => ['nullable', 'string', 'max:160'],
                'why_intro'            => ['nullable', 'string', 'max:500'],
                'testimonials_heading' => ['nullable', 'string', 'max:120'],
                'testimonials_intro'   => ['nullable', 'string', 'max:500'],

                // Fleet band
                'fleet_heading'        => ['nullable', 'string', 'max:160'],
                'fleet_features'       => ['nullable', 'array', 'max:20'],
                'fleet_features.*'     => ['nullable', 'string', 'max:60'],
                'fleet_bg'             => ['nullable', 'image', 'max:8192'],

                // Contact / map
                'contact_heading'      => ['nullable', 'string', 'max:120'],
                'contact_intro'        => ['nullable', 'string', 'max:500'],
                'map_embed_url'        => ['nullable', 'url', 'max:1000'],
            ],
            'social' => [
                'facebook'  => ['nullable', 'url'],
                'instagram' => ['nullable', 'url'],
                'twitter'   => ['nullable', 'url'],
                'linkedin'  => ['nullable', 'url'],
                'whatsapp'  => ['nullable', 'url'],
                'tripadvisor' => ['nullable', 'url'],
            ],
            'seo' => [
                'meta_title'       => ['nullable', 'string', 'max:160'],
                'meta_description' => ['nullable', 'string', 'max:400'],
            ],
            default => [],
        };
    }

    /** Fields written with type = encrypted. */
    public function encryptedKeys(): array
    {
        return ['mail_password', 'stripe_secret', 'stripe_webhook_secret', 'paypal_secret'];
    }
}
