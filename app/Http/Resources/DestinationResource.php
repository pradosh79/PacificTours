<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->uuid,
            'name'        => $this->t('name'),
            'slug'        => $this->slug,
            'country'     => $this->whenLoaded('country', fn () => $this->country->name),
            'description' => $this->short_description,
            'thumbnail'   => upload_url($this->thumbnail),
            'featured'    => $this->is_featured,
            'tours_count' => $this->whenCounted('tours'),
        ];
    }
}
