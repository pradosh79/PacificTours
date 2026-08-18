@extends('layouts.admin')
@section('title', 'Bookings report')

@section('content')
<div class="panel mb-3">@include('admin.reports.partials.filters')</div>
@include('admin.reports.partials.cards')

<div class="panel">
    <table class="table table-sm mb-0">
        <thead><tr><th>Booking</th><th>Customer</th><th>Tour</th><th>Booked</th><th>Travel</th><th>Guests</th><th class="text-end">Total</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($rows as $row)
            <tr>
                <td>{{ $row['booking_number'] }}</td>
                <td>{{ $row['customer'] }}</td>
                <td class="text-truncate" style="max-width:14rem">{{ $row['tour'] }}</td>
                <td>{{ $row['booked_at'] }}</td>
                <td>{{ $row['travel_date'] }}</td>
                <td>{{ $row['guests'] }}</td>
                <td class="text-end">{{ money($row['total']) }}</td>
                <td>{{ Str::headline($row['status']) }}</td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-muted py-5">Nothing in this range.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
