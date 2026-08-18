<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->uuid,
            'author'   => $this->reviewer_name,
            'rating'   => $this->rating,
            'breakdown'=> array_filter([
                'value'   => $this->rating_value,
                'service' => $this->rating_service,
                'guide'   => $this->rating_guide,
            ]),
            'title'    => $this->title,
            'comment'  => $this->comment,
            'verified' => $this->is_verified_purchase,
            'images'   => $this->whenLoaded('images', fn () => $this->images->map(fn ($i) => upload_url($i->path))),
            'reply'    => $this->admin_reply,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
