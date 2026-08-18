<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\BookingData;
use App\DTOs\PriceBreakdown;
use App\Enums\DepositType;
use App\Models\Tour;
use App\Models\TourDeparture;

/**
 * Single source of truth for money. The wizard, the admin booking form and the
 * API all quote through this class, so a price can never be computed twice in
 * two different places.
 *
 * Order of operations:
 *   line totals -> tour/flash discount -> coupon -> service fee -> tax -> deposit
 */
class PricingService
{
    public function __construct(private readonly CouponService $coupons) {}

    public function quote(Tour $tour, BookingData $data, ?TourDeparture $departure = null): PriceBreakdown
    {
        $adultUnit  = (float) ($departure?->price_override ?? $tour->base_price);
        $childUnit  = (float) ($departure?->child_price_override ?? $tour->child_price);
        $infantUnit = (float) $tour->infant_price;

        $subtotal = round(
            $adultUnit * $data->adults + $childUnit * $data->children + $infantUnit * $data->infants,
            2
        );

        $tourDiscount = $this->tourDiscount($tour, $subtotal);
        $afterTour    = round($subtotal - $tourDiscount, 2);

        [$couponDiscount, $couponId, $couponCode] = $this->couponDiscount($tour, $data, $afterTour);

        $net        = round($afterTour - $couponDiscount, 2);
        $serviceFee = round((float) $tour->service_fee, 2);
        $taxTotal   = round(($net + $serviceFee) * ((float) $tour->tax_percentage / 100), 2);
        $grandTotal = round($net + $serviceFee + $taxTotal, 2);

        return new PriceBreakdown(
            adultUnitPrice: $adultUnit,
            childUnitPrice: $childUnit,
            infantUnitPrice: $infantUnit,
            adults: $data->adults,
            children: $data->children,
            infants: $data->infants,
            subtotal: $subtotal,
            tourDiscount: $tourDiscount,
            couponDiscount: $couponDiscount,
            serviceFee: $serviceFee,
            taxTotal: $taxTotal,
            grandTotal: $grandTotal,
            depositAmount: $data->payDeposit ? $this->deposit($tour, $grandTotal) : 0.0,
            currency: $tour->currency ?? config('travel.currency.default'),
            couponId: $couponId,
            couponCode: $couponCode,
        );
    }

    /** Best of: flash sale currently running, or the tour's own discount. */
    public function tourDiscount(Tour $tour, float $subtotal): float
    {
        $own = $tour->hasDiscount()
            ? $tour->discount_type->apply($subtotal, (float) $tour->discount_value)
            : 0.0;

        $sale = $tour->relationLoaded('flashSales')
            ? $tour->flashSales->firstWhere(fn ($s) => $s->is_active && $s->starts_at <= now() && $s->ends_at >= now())
            : $tour->flashSales()->running()->first();

        $flash = $sale ? $sale->discount_type->apply($subtotal, (float) $sale->discount_value) : 0.0;

        return round(max($own, $flash), 2);
    }

    public function deposit(Tour $tour, float $grandTotal): float
    {
        return match ($tour->deposit_type) {
            DepositType::Percentage => round($grandTotal * ((float) $tour->deposit_value / 100), 2),
            DepositType::Fixed      => min((float) $tour->deposit_value, $grandTotal),
            DepositType::Disabled   => 0.0,
        };
    }

    /** Denormalised list price used for sorting and filtering. */
    public function refreshSalePrice(Tour $tour): void
    {
        $tour->forceFill([
            'sale_price' => round((float) $tour->base_price - $this->tourDiscount($tour, (float) $tour->base_price), 2),
        ])->saveQuietly();
    }

    /** @return array{0: float, 1: ?int, 2: ?string} */
    private function couponDiscount(Tour $tour, BookingData $data, float $base): array
    {
        if (blank($data->couponCode)) {
            return [0.0, null, null];
        }

        $coupon = $this->coupons->validate($data->couponCode, $tour, $base, $data->userId, $data->customerEmail);

        return [$this->coupons->discountFor($coupon, $base), $coupon->id, $coupon->code];
    }
}
