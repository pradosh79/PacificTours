@extends('layouts.admin')
@section('title', 'Tour performance')

@section('content')
<div class="panel mb-3">@include('admin.reports.partials.filters')</div>
@include('admin.reports.partials.cards')

<div class="panel">
    <table class="table table-sm mb-0">
        <thead><tr><th>Tour</th><th>Category</th><th class="text-end">Views</th><th class="text-end">Bookings</th><th class="text-end">Conversion</th><th class="text-end">Revenue</th><th class="text-end">Rating</th></tr></thead>
        <tbody>
        @forelse ($rows as $row)
            <tr>
                <td class="fw-semibold text-truncate" style="max-width:16rem">{{ $row['title'] }}</td>
                <td>{{ $row['category'] }}</td>
                <td class="text-end">{{ number_format($row['views']) }}</td>
                <td class="text-end">{{ $row['bookings'] }}</td>
                <td class="text-end">{{ $row['conversion'] }}%</td>
                <td class="text-end">{{ money($row['revenue']) }}</td>
                <td class="text-end">{{ number_format((float) $row['rating'], 1) }}</td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-5">Nothing in this range.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
