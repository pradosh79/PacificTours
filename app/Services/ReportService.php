<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Read-only aggregation for the five admin report screens.
 *
 * Each method returns the exact shape its Blade view expects:
 *   • cards  — [label => stringified value] for the top stat cards
 *   • rows   — Collection of associative arrays with the exact keys the table uses
 *   • plus method-specific extras (series/counts for revenue, byGateway for payments)
 *
 * Same payload feeds the Blade view, the Excel export and the PDF export,
 * so a query is never repeated.
 */
class ReportService
{
    public function revenue(array $filters): array
    {
        [$from, $to] = $this->range($filters);

        $daily = Booking::revenueCounted()
            ->whereBetween('created_at', [$from, $to])
            ->select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as bookings'),
                DB::raw('SUM(subtotal) as subtotal'),
                DB::raw('SUM(tour_discount + coupon_discount) as discounts'),
                DB::raw('SUM(tax_total) as tax'),
                DB::raw('SUM(grand_total) as gross'),
                DB::raw('SUM(paid_amount) as collected'),
                DB::raw('SUM(COALESCE(refunded_amount, 0)) as refunded'),
            )
            ->groupBy('day')->orderBy('day')->get();

        $rows = $daily->map(fn ($r) => [
            'period'    => Carbon::parse($r->day)->format('D d M Y'),
            'day'       => (string) $r->day,
            'bookings'  => (int) $r->bookings,
            'gross'     => (float) $r->gross,
            'discounts' => (float) $r->discounts,
            'tax'       => (float) $r->tax,
            'collected' => (float) $r->collected,
            'refunded'  => (float) $r->refunded,
            'net'       => (float) $r->gross - (float) $r->discounts,
        ]);

        return [
            'cards' => [
                'bookings'  => number_format((int) $rows->sum('bookings')),
                'gross'     => money($rows->sum('gross')),
                'collected' => money($rows->sum('collected')),
                'net'       => money($rows->sum('net')),
            ],
            'rows'   => $rows,
            'series' => $rows->pluck('gross', 'day')->toArray(),
            'counts' => $rows->pluck('bookings', 'day')->toArray(),
            'range'  => compact('from', 'to'),
        ];
    }

    public function bookings(array $filters): array
    {
        [$from, $to] = $this->range($filters);

        $bookings = Booking::with(['tour:id,title'])
            ->whereBetween('created_at', [$from, $to])
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->latest('id')
            ->get();

        $rows = $bookings->map(fn (Booking $b) => [
            'booking_number' => $b->booking_number,
            'customer'       => trim(($b->customer_first_name ?? '').' '.($b->customer_last_name ?? '')) ?: '—',
            'email'          => $b->customer_email,
            'tour'           => $b->tour?->title ?? '—',
            'booked_at'      => $b->created_at->format('d M Y'),
            'travel_date'    => optional($b->travel_date)->format('d M Y') ?? '—',
            'guests'         => (int) $b->adults + (int) $b->children + (int) $b->infants,
            'total'          => (float) $b->grand_total,
            'status'         => $b->status?->value ?? 'pending',
        ]);

        $counts = $bookings->countBy(fn ($b) => $b->status?->value ?? 'pending');

        return [
            'cards' => [
                'total'     => number_format($bookings->count()),
                'confirmed' => number_format((int) ($counts[BookingStatus::Confirmed->value] ?? 0)),
                'pending'   => number_format((int) ($counts[BookingStatus::Pending->value] ?? 0)),
                'cancelled' => number_format((int) ($counts[BookingStatus::Cancelled->value] ?? 0)),
            ],
            'rows'  => $rows,
            'range' => compact('from', 'to'),
        ];
    }

    public function customers(array $filters): array
    {
        [$from, $to] = $this->range($filters);

        $customers = User::customers()
            ->withCount(['bookings' => fn ($q) => $q->whereBetween('created_at', [$from, $to])])
            ->withSum(
                ['bookings' => fn ($q) => $q->revenueCounted()->whereBetween('created_at', [$from, $to])],
                'grand_total'
            )
            ->having('bookings_count', '>', 0)
            ->orderByDesc('bookings_sum_grand_total')
            ->get();

        $rows = $customers->map(function (User $u) {
            $lastBooking = $u->bookings()->latest('created_at')->value('created_at');

            return [
                'name'           => trim(($u->first_name ?? '').' '.($u->last_name ?? '')) ?: '—',
                'email'          => $u->email,
                'joined'         => $u->created_at->format('d M Y'),
                'bookings'       => (int) $u->bookings_count,
                'lifetime_value' => (float) ($u->bookings_sum_grand_total ?? 0),
                'last_booking'   => $lastBooking ? Carbon::parse($lastBooking)->format('d M Y') : null,
            ];
        });

        return [
            'cards' => [
                'active_customers' => number_format($rows->count()),
                'total_bookings'   => number_format((int) $rows->sum('bookings')),
                'revenue'          => money($rows->sum('lifetime_value')),
                'avg_ltv'          => money($rows->count() ? $rows->sum('lifetime_value') / $rows->count() : 0),
            ],
            'rows'  => $rows,
            'range' => compact('from', 'to'),
        ];
    }

    public function tours(array $filters): array
    {
        [$from, $to] = $this->range($filters);

        $tours = Tour::with('category:id,name')
            ->withCount(['bookings' => fn ($q) => $q->revenueCounted()->whereBetween('created_at', [$from, $to])])
            ->withSum(
                ['bookings' => fn ($q) => $q->revenueCounted()->whereBetween('created_at', [$from, $to])],
                'grand_total'
            )
            ->orderByDesc('bookings_sum_grand_total')
            ->get();

        $rows = $tours->map(function (Tour $t) {
            $views    = (int) ($t->views_count ?? 0);
            $bookings = (int) $t->bookings_count;
            $conv     = $views > 0 ? round(($bookings / $views) * 100, 1) : 0;

            return [
                'title'      => $t->title,
                'category'   => $t->category?->name ?? '—',
                'views'      => $views,
                'bookings'   => $bookings,
                'conversion' => $conv,
                'revenue'    => (float) ($t->bookings_sum_grand_total ?? 0),
                'rating'     => (float) ($t->average_rating ?? 0),
            ];
        });

        return [
            'cards' => [
                'tours_sold'  => number_format((int) $rows->sum('bookings')),
                'revenue'     => money($rows->sum('revenue')),
                'avg_rating'  => number_format($tours->avg('average_rating') ?: 0, 1),
                'top_tour'    => (string) ($rows->first()['title'] ?? '—'),
            ],
            'rows'  => $rows,
            'range' => compact('from', 'to'),
        ];
    }

    public function payments(array $filters): array
    {
        [$from, $to] = $this->range($filters);

        $payments = Payment::with('booking:id,booking_number')
            ->whereBetween('created_at', [$from, $to])
            ->when($filters['gateway'] ?? null, fn ($q, $v) => $q->where('gateway', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->latest('id')
            ->get();

        $rows = $payments->map(fn (Payment $p) => [
            'date'           => ($p->paid_at ?? $p->created_at)->format('d M Y'),
            'booking_number' => $p->booking?->booking_number ?? '—',
            'gateway'        => $p->gateway?->value ?? '—',
            'type'           => $p->type?->value ?? 'full',
            'amount'         => (float) $p->amount,
            'status'         => $p->status?->value ?? 'pending',
        ]);

        // Two-way aggregate: succeeded collected minus refunded, per gateway
        $succeeded = $payments->where('status.value', 'succeeded');
        $refunded  = $payments->where('status.value', 'refunded');

        $byGateway = $succeeded->groupBy(fn (Payment $p) => $p->gateway?->value ?? 'manual')
            ->map(function (Collection $group, string $gateway) use ($refunded) {
                $collected = (float) $group->sum('amount');
                $r         = (float) $refunded->where('gateway.value', $gateway)->sum('amount');

                return [
                    'gateway'   => $gateway,
                    'count'     => $group->count(),
                    'collected' => $collected,
                    'refunded'  => $r,
                    'net'       => $collected - $r,
                ];
            })->values();

        return [
            'cards' => [
                'transactions' => number_format($payments->count()),
                'collected'    => money($succeeded->sum('amount')),
                'refunded'     => money($refunded->sum('amount')),
                'net'          => money($succeeded->sum('amount') - $refunded->sum('amount')),
            ],
            'rows'      => $rows,
            'byGateway' => $byGateway,
            'range'     => compact('from', 'to'),
        ];
    }

    /** @return array{0: string, 1: string} */
    private function range(array $filters): array
    {
        return [
            ($filters['date_from'] ?? now()->startOfMonth()->toDateString()).' 00:00:00',
            ($filters['date_to'] ?? now()->toDateString()).' 23:59:59',
        ];
    }
}
