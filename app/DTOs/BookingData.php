<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * Everything the booking wizard collected, gateway-agnostic.
 */
final class BookingData extends BaseData
{
    /** @param  array<int, TravelerData>  $travelers */
    public function __construct(
        public readonly int $tourId,
        public readonly ?int $departureId,
        public readonly string $travelDate,
        public readonly int $adults,
        public readonly int $children,
        public readonly int $infants,
        public readonly string $customerFirstName,
        public readonly ?string $customerLastName,
        public readonly string $customerEmail,
        public readonly ?string $customerPhone,
        public readonly ?string $customerCountry = null,
        public readonly ?string $customerAddress = null,
        public readonly ?string $couponCode = null,
        public readonly ?string $customerNote = null,
        public readonly array $travelers = [],
        public readonly ?int $userId = null,
        public readonly string $source = 'web',
        public readonly bool $payDeposit = false,
        public readonly ?string $ipAddress = null,
    ) {}

    public static function fromArray(array $d): self
    {
        return new self(
            tourId: (int) $d['tour_id'],
            departureId: isset($d['tour_departure_id']) ? (int) $d['tour_departure_id'] : null,
            travelDate: $d['travel_date'],
            adults: (int) ($d['adults'] ?? 1),
            children: (int) ($d['children'] ?? 0),
            infants: (int) ($d['infants'] ?? 0),
            customerFirstName: $d['customer_first_name'],
            customerLastName: $d['customer_last_name'] ?? null,
            customerEmail: $d['customer_email'],
            customerPhone: $d['customer_phone'] ?? null,
            customerCountry: $d['customer_country'] ?? null,
            customerAddress: $d['customer_address'] ?? null,
            couponCode: $d['coupon_code'] ?? null,
            customerNote: $d['customer_note'] ?? null,
            travelers: array_map(fn (array $t) => TravelerData::fromArray($t), $d['travelers'] ?? []),
            userId: $d['user_id'] ?? null,
            source: $d['source'] ?? 'web',
            payDeposit: (bool) ($d['pay_deposit'] ?? false),
            ipAddress: $d['ip_address'] ?? null,
        );
    }

    public function seatCount(): int
    {
        return $this->adults + $this->children;
    }

    public function toBookingColumns(): array
    {
        return [
            'tour_id'             => $this->tourId,
            'tour_departure_id'   => $this->departureId,
            'user_id'             => $this->userId,
            'customer_first_name' => $this->customerFirstName,
            'customer_last_name'  => $this->customerLastName,
            'customer_email'      => $this->customerEmail,
            'customer_phone'      => $this->customerPhone,
            'customer_country'    => $this->customerCountry,
            'customer_address'    => $this->customerAddress,
            'travel_date'         => $this->travelDate,
            'adults'              => $this->adults,
            'children'            => $this->children,
            'infants'             => $this->infants,
            'customer_note'       => $this->customerNote,
            'source'              => $this->source,
            'ip_address'          => $this->ipAddress,
        ];
    }
}
