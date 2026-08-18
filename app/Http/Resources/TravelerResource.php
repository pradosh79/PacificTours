<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type'            => $this->type->value,
            'name'            => $this->full_name,
            'date_of_birth'   => $this->date_of_birth?->toDateString(),
            'nationality'     => $this->nationality,
            'passport_number' => $this->when($request->user()?->isStaff(), $this->passport_number),
            'special_request' => $this->special_request,
        ];
    }
}
