<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name'  => $this->t('name'),
            'slug'  => $this->slug,
            'icon'  => $this->icon,
            'image' => upload_url($this->image),
            'tours_count' => $this->whenCounted('tours'),
        ];
    }
}
