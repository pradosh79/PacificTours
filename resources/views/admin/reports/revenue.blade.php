@extends('layouts.admin')
@section('title', 'Revenue report')

@section('content')
<div class="panel mb-3">@include('admin.reports.partials.filters')</div>
@include('admin.reports.partials.cards')

<div class="panel mb-3">
    <header class="panel-head"><h2 class="h6 mb-0">Revenue over time</h2></header>
    <div class="panel-body"><canvas id="chart-revenue" height="90" data-revenue='@json($series)' data-bookings='@json($counts ?? [])'></canvas></div>
</div>

<div class="panel">
    <table class="table table-sm mb-0">
        <thead><tr><th>Period</th><th class="text-end">Bookings</th><th class="text-end">Gross</th><th class="text-end">Discounts</th><th class="text-end">Tax</th><th class="text-end">Net</th></tr></thead>
        <tbody>
        @foreach ($rows as $row)
            <tr>
                <td>{{ $row['period'] }}</td>
                <td class="text-end">{{ $row['bookings'] }}</td>
                <td class="text-end">{{ money($row['gross']) }}</td>
                <td class="text-end">−{{ money($row['discounts']) }}</td>
                <td class="text-end">{{ money($row['tax']) }}</td>
                <td class="text-end fw-semibold">{{ money($row['net']) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
