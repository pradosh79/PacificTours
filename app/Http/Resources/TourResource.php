<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->uuid,
            'code'          => $this->code,
            'title'         => $this->t('title'),
            'slug'          => $this->slug,
            'summary'       => $this->t('summary'),
            'description'   => $this->when($request->routeIs('*.show'), fn () => $this->t('description')),
            'duration'      => [
                'days'   => $this->duration_days,
                'nights' => $this->duration_nights,
                'label'  => "{$this->duration_days}D / {$this->duration_nights}N",
            ],
            'pricing' => [
                'currency'    => $this->currency,
                'base'        => (float) $this->base_price,
                'sale'        => (float) $this->sale_price,
                'child'       => (float) $this->child_price,
                'infant'      => (float) $this->infant_price,
                'has_discount'=> $this->hasDiscount(),
                'deposit'     => ['type' => $this->deposit_type->value, 'value' => (float) $this->deposit_value],
            ],
            'rating'    => ['average' => (float) $this->average_rating, 'count' => $this->reviews_count],
            'flags'     => [
                'featured'    => $this->is_featured,
                'popular'     => $this->is_popular,
                'recommended' => $this->is_recommended,
            ],
            'media' => [
                'thumbnail' => upload_url($this->thumbnail),
                'banner'    => upload_url($this->banner),
                'gallery'   => TourImageResource::collection($this->whenLoaded('images')),
            ],
            'category'     => new TourCategoryResource($this->whenLoaded('category')),
            'destination'  => new DestinationResource($this->whenLoaded('destination')),
            'itinerary'    => ItineraryResource::collection($this->whenLoaded('itineraries')),
            'included'     => $this->whenLoaded('inclusions', fn () => $this->inclusions->where('type', 'included')->pluck('content')->values()),
            'excluded'     => $this->whenLoaded('inclusions', fn () => $this->inclusions->where('type', 'excluded')->pluck('content')->values()),
            'highlights'   => $this->whenLoaded('highlights', fn () => $this->highlights->pluck('content')),
            'faqs'         => $this->whenLoaded('faqs', fn () => $this->faqs->map->only(['question', 'answer'])),
            'departures'   => DepartureResource::collection($this->whenLoaded('departures')),
            'reviews'      => ReviewResource::collection($this->whenLoaded('approvedReviews')),
            'links'        => ['self' => route('tours.show', $this->slug)],
        ];
    }
}
