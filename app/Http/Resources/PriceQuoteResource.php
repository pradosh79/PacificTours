<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** Wraps a PriceBreakdown DTO for the live price panel and the API. */
class PriceQuoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'lines' => [
                ['label' => "Adults × {$this->adults}",     'amount' => $this->adultUnitPrice * $this->adults],
                ['label' => "Children × {$this->children}", 'amount' => $this->childUnitPrice * $this->children],
                ['label' => "Infants × {$this->infants}",   'amount' => $this->infantUnitPrice * $this->infants],
            ],
            'subtotal'        => $this->subtotal,
            'tour_discount'   => $this->tourDiscount,
            'coupon'          => ['code' => $this->couponCode, 'discount' => $this->couponDiscount],
            'service_fee'     => $this->serviceFee,
            'tax'             => $this->taxTotal,
            'total'           => $this->grandTotal,
            'deposit'         => $this->depositAmount,
            'payable_now'     => $this->payableNow(),
            'currency'        => $this->currency,
        ];
    }
}
