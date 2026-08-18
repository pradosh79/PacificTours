@extends('layouts.app')

{{-- PLACEHOLDER VIEW — variable contract: $stats, $upcoming, $recent, $notifications --}}

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-4">Welcome back, {{ auth()->user()->first_name }}</h1>

    <div class="row g-3 mb-4">
        @foreach ([
            ['Bookings', $stats['bookings']], ['Upcoming', $stats['upcoming']],
            ['Completed', $stats['completed']], ['Spent', money($stats['spent'])],
            ['Balance due', money($stats['due'])], ['Saved tours', $stats['wishlist']],
        ] as [$label, $value])
            <div class="col-6 col-md-4 col-lg-2">
                <div class="border rounded p-3 text-center">
                    <p class="h5 mb-0">{{ $value }}</p>
                    <p class="small text-muted mb-0">{{ $label }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <section class="mb-4">
        <h2 class="h6">Next departures</h2>
        @forelse ($upcoming as $booking)
            <div class="border rounded p-3 mb-2 d-flex justify-content-between">
                <div>
                    <a href="{{ route('customer.bookings.show', $booking->uuid) }}">{{ $booking->tour->title }}</a>
                    <span class="d-block small text-muted">{{ $booking->travel_date->format('D d M Y') }} · {{ $booking->booking_number }}</span>
                </div>
                <div class="text-end">
                    <span class="badge text-bg-{{ $booking->status->badge() }}">{{ $booking->status->label() }}</span>
                    @if ($booking->due_amount > 0)
                        <a class="d-block small" href="{{ route('customer.bookings.pay', $booking->uuid) }}">Pay {{ money($booking->due_amount) }}</a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted">Nothing booked yet. <a href="{{ route('tours.index') }}">Find a trip</a>.</p>
        @endforelse
    </section>
</div>
@endsection
