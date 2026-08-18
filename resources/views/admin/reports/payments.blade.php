@extends('layouts.admin')
@section('title', 'Payments report')

@section('content')
<div class="panel mb-3">@include('admin.reports.partials.filters')</div>
@include('admin.reports.partials.cards')

<div class="panel mb-3">
    <header class="panel-head"><h2 class="h6 mb-0">By gateway</h2></header>
    <table class="table table-sm mb-0">
        <thead><tr><th>Gateway</th><th class="text-end">Transactions</th><th class="text-end">Collected</th><th class="text-end">Refunded</th><th class="text-end">Net</th></tr></thead>
        <tbody>
        @foreach ($byGateway as $row)
            <tr>
                <td>{{ Str::headline($row['gateway']) }}</td>
                <td class="text-end">{{ $row['count'] }}</td>
                <td class="text-end">{{ money($row['collected']) }}</td>
                <td class="text-end text-danger">−{{ money($row['refunded']) }}</td>
                <td class="text-end fw-semibold">{{ money($row['net']) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="panel">
    <header class="panel-head"><h2 class="h6 mb-0">Transactions</h2></header>
    <table class="table table-sm mb-0">
        <thead><tr><th>Date</th><th>Booking</th><th>Gateway</th><th>Type</th><th class="text-end">Amount</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($rows as $row)
            <tr>
                <td>{{ $row['date'] }}</td>
                <td>{{ $row['booking_number'] }}</td>
                <td>{{ Str::headline($row['gateway']) }}</td>
                <td>{{ Str::headline($row['type']) }}</td>
                <td class="text-end">{{ money($row['amount']) }}</td>
                <td>{{ Str::headline($row['status']) }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-5">Nothing in this range.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
