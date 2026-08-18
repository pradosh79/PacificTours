@extends('layouts.admin')
@section('title', 'Invoices')

@section('content')
<div class="panel">
    <header class="panel-head">
        <form class="d-flex gap-2">
            <input name="keyword" class="form-control form-control-sm w-auto" placeholder="Invoice number" value="{{ request('keyword') }}">
            <div class="form-check align-self-center">
                <input class="form-check-input" type="checkbox" name="unpaid_only" value="1" id="uo" @checked(request('unpaid_only'))>
                <label class="form-check-label small" for="uo">Outstanding only</label>
            </div>
            <button class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>
    </header>

    <table class="table align-middle mb-0">
        <thead><tr><th>Invoice</th><th>Booking</th><th>Customer</th><th>Issued</th><th class="text-end">Total</th><th class="text-end">Balance</th><th></th></tr></thead>
        <tbody>
        @forelse ($invoices as $invoice)
            <tr>
                <td class="fw-semibold">{{ $invoice->invoice_number }}</td>
                <td><a href="{{ route('admin.bookings.show', $invoice->booking->uuid) }}">{{ $invoice->booking->booking_number }}</a></td>
                <td>{{ $invoice->booking->customer_name }}</td>
                <td class="small text-muted">{{ $invoice->issued_at->format('d M Y') }}</td>
                <td class="text-end">{{ money($invoice->total) }}</td>
                <td class="text-end {{ $invoice->balance > 0 ? 'text-danger' : '' }}">{{ money($invoice->balance) }}</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.invoices.download', $invoice->uuid) }}">PDF</a>
                    <form class="d-inline" method="POST" action="{{ route('admin.invoices.regenerate', $invoice->uuid) }}">
                        @csrf<button class="btn btn-sm btn-outline-secondary">Rebuild</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-5">No invoices.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="panel-foot">{{ $invoices->withQueryString()->links() }}</div>
</div>
@endsection
