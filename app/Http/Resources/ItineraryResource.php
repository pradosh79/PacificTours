<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItineraryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'day'           => $this->day_number,
            'title'         => $this->t('title'),
            'description'   => $this->t('description'),
            'accommodation' => $this->accommodation,
            'meals'         => $this->meals,
            'image'         => $this->image ? upload_url($this->image) : null,
        ];
    }
}
