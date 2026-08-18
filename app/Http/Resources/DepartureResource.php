<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartureResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->uuid,
            'start_date' => $this->start_date->toDateString(),
            'end_date'   => $this->end_date?->toDateString(),
            'price'      => $this->price_override ? (float) $this->price_override : null,
            'seats'      => [
                'total'     => $this->seats_total,
                'available' => $this->seats_available,
            ],
            'status'     => $this->status,
        ];
    }
}
