<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->uuid,
            'booking_number' => $this->booking_number,
            'status'         => ['value' => $this->status->value, 'label' => $this->status->label()],
            'payment_status' => ['value' => $this->payment_status->value, 'label' => $this->payment_status->label()],
            'travel_date'    => $this->travel_date->toDateString(),
            'return_date'    => $this->return_date?->toDateString(),
            'guests'         => [
                'adults'   => $this->adults,
                'children' => $this->children,
                'infants'  => $this->infants,
                'total'    => $this->total_guests,
            ],
            'customer' => [
                'name'  => $this->customer_name,
                'email' => $this->customer_email,
                'phone' => $this->customer_phone,
            ],
            'pricing' => [
                'currency'        => $this->currency,
                'subtotal'        => (float) $this->subtotal,
                'tour_discount'   => (float) $this->tour_discount,
                'coupon_discount' => (float) $this->coupon_discount,
                'service_fee'     => (float) $this->service_fee,
                'tax'             => (float) $this->tax_total,
                'total'           => (float) $this->grand_total,
                'deposit'         => (float) $this->deposit_amount,
                'paid'            => (float) $this->paid_amount,
                'due'             => (float) $this->due_amount,
            ],
            'tour'      => new TourResource($this->whenLoaded('tour')),
            'travelers' => TravelerResource::collection($this->whenLoaded('travelers')),
            'payments'  => PaymentResource::collection($this->whenLoaded('payments')),
            'invoice'   => new InvoiceResource($this->whenLoaded('invoice')),
            'created_at'=> $this->created_at->toIso8601String(),
        ];
    }
}
