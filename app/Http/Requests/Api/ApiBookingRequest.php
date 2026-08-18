<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Requests\Web\BookingWizardRequest;

/**
 * The API accepts the same payload as the wizard minus the UI-only fields, so
 * a future Figma/SPA frontend can post to either surface unchanged.
 */
class ApiBookingRequest extends BookingWizardRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'gateway' => ['nullable', 'string', 'in:stripe,paypal,bank_transfer'],
            'terms'   => ['nullable', 'accepted'],
        ]);
    }
}
