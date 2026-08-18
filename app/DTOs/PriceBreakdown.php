<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * Immutable result of PricingService. Every number written on a booking row
 * comes from here, so the quote shown at checkout is the quote that is charged.
 */
final class PriceBreakdown extends BaseData
{
    public function __construct(
        public readonly float $adultUnitPrice,
        public readonly float $childUnitPrice,
        public readonly float $infantUnitPrice,
        public readonly int $adults,
        public readonly int $children,
        public readonly int $infants,
        public readonly float $subtotal,
        public readonly float $tourDiscount,
        public readonly float $couponDiscount,
        public readonly float $serviceFee,
        public readonly float $taxTotal,
        public readonly float $grandTotal,
        public readonly float $depositAmount,
        public readonly string $currency,
        public readonly ?int $couponId = null,
        public readonly ?string $couponCode = null,
    ) {}

    public function payableNow(): float
    {
        return $this->depositAmount > 0 ? $this->depositAmount : $this->grandTotal;
    }

    public function toBookingColumns(): array
    {
        return [
            'adult_unit_price'  => $this->adultUnitPrice,
            'child_unit_price'  => $this->childUnitPrice,
            'infant_unit_price' => $this->infantUnitPrice,
            'subtotal'          => $this->subtotal,
            'tour_discount'     => $this->tourDiscount,
            'coupon_discount'   => $this->couponDiscount,
            'service_fee'       => $this->serviceFee,
            'tax_total'         => $this->taxTotal,
            'grand_total'       => $this->grandTotal,
            'deposit_amount'    => $this->depositAmount,
            'due_amount'        => $this->grandTotal,
            'currency'          => $this->currency,
            'coupon_id'         => $this->couponId,
        ];
    }
}
