@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-3 mb-4">
        @foreach ([
            ['Total tours',      number_format($cards['tours']),            'compass'],
            ['Total bookings',   number_format($cards['bookings']),         'ticket'],
            ["Today's bookings", number_format($cards['bookings_today']),   'calendar'],
            ['Pending bookings', number_format($cards['bookings_pending']), 'clock'],
            ['Completed tours',  number_format($cards['tours_completed']),  'check'],
            ['Revenue',          money($cards['revenue']),                  'card'],
        ] as [$label, $value, $icon])
            <div class="col-6 col-lg-4 col-xl-2">
                <article class="stat-card">
                    <x-icon :name="$icon" />
                    <p class="stat-value">{{ $value }}</p>
                    <p class="stat-label">{{ $label }}</p>
                </article>
            </div>
        @endforeach
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <section class="panel">
                <header class="panel-head">
                    <h2 class="h6 mb-0">Revenue &amp; bookings · last 12 months</h2>
                </header>
                <div class="panel-body">
                    <canvas id="chart-revenue" height="110"
                            data-revenue='@json($charts['monthly_revenue'])'
                            data-bookings='@json($charts['monthly_bookings'])'></canvas>
                </div>
            </section>

            <section class="panel mt-3">
                <header class="panel-head d-flex justify-content-between">
                    <h2 class="h6 mb-0">Recent bookings</h2>
                    <a class="small" href="{{ route('admin.bookings.index') }}">View all</a>
                </header>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead><tr><th>Booking</th><th>Customer</th><th>Tour</th><th>Travel</th><th class="text-end">Total</th><th>Status</th></tr></thead>
                        <tbody>
                        @forelse ($recent_bookings as $booking)
                            <tr>
                                <td><a href="{{ route('admin.bookings.show', $booking->uuid) }}">{{ $booking->booking_number }}</a></td>
                                <td>{{ $booking->customer_name }}</td>
                                <td class="text-truncate" style="max-width: 16rem">{{ $booking->tour?->title }}</td>
                                <td>{{ $booking->travel_date->format('d M Y') }}</td>
                                <td class="text-end">{{ money($booking->grand_total) }}</td>
                                <td><span class="badge text-bg-{{ $booking->status->badge() }}">{{ $booking->status->label() }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-muted py-4 text-center">No bookings yet. They will appear here the moment one comes in.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="col-xl-4">
            <section class="panel">
                <header class="panel-head"><h2 class="h6 mb-0">Top tours</h2></header>
                <ul class="list-unstyled panel-body mb-0">
                    @foreach ($charts['top_tours'] as $tour)
                        <li class="d-flex justify-content-between border-bottom py-2">
                            <span class="text-truncate pe-2">{{ $tour['title'] }}</span>
                            <span class="text-nowrap small text-muted">{{ $tour['bookings'] }} · {{ money($tour['revenue']) }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Upcoming departures</h2></header>
                <ul class="list-unstyled panel-body mb-0">
                    @foreach ($upcoming_tours as $booking)
                        <li class="border-bottom py-2">
                            <a href="{{ route('admin.bookings.show', $booking->uuid) }}">{{ $booking->tour?->title }}</a>
                            <span class="d-block small text-muted">{{ $booking->travel_date->format('D d M') }} · {{ $booking->total_guests }} guests</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Latest payments</h2></header>
                <ul class="list-unstyled panel-body mb-0">
                    @foreach ($latest_payments as $payment)
                        <li class="d-flex justify-content-between border-bottom py-2">
                            <span>{{ $payment->booking?->booking_number }}</span>
                            <span class="small">{{ money($payment->amount) }} · {{ $payment->gateway->label() }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
@endsection
