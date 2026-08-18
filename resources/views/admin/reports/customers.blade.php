@extends('layouts.admin')
@section('title', 'Customers report')

@section('content')
<div class="panel mb-3">@include('admin.reports.partials.filters')</div>
@include('admin.reports.partials.cards')

<div class="panel">
    <table class="table table-sm mb-0">
        <thead><tr><th>Customer</th><th>Email</th><th>Joined</th><th class="text-end">Bookings</th><th class="text-end">Lifetime value</th><th>Last booking</th></tr></thead>
        <tbody>
        @forelse ($rows as $row)
            <tr>
                <td class="fw-semibold">{{ $row['name'] }}</td>
                <td>{{ $row['email'] }}</td>
                <td>{{ $row['joined'] }}</td>
                <td class="text-end">{{ $row['bookings'] }}</td>
                <td class="text-end">{{ money($row['lifetime_value']) }}</td>
                <td>{{ $row['last_booking'] ?? '—' }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-5">Nothing in this range.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
