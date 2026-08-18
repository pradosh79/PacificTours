<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->uuid,
            'gateway'        => $this->gateway->label(),
            'type'           => $this->type->value,
            'amount'         => (float) $this->amount,
            'currency'       => $this->currency,
            'status'         => $this->status->value,
            'transaction_id' => $this->when($request->user()?->isStaff(), $this->transaction_id),
            'paid_at'        => $this->paid_at?->toIso8601String(),
        ];
    }
}
