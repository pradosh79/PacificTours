@extends('customer.layout')
@section('heading', 'Invoices')

@section('panel')
<table class="table table-sm align-middle">
    <thead><tr><th>Invoice</th><th>Booking</th><th>Issued</th><th class="text-end">Total</th><th class="text-end">Balance</th><th></th></tr></thead>
    <tbody>
    @forelse ($invoices as $invoice)
        <tr>
            <td>{{ $invoice->invoice_number }}</td>
            <td><a href="{{ route('customer.bookings.show', $invoice->booking->uuid) }}">{{ $invoice->booking->booking_number }}</a></td>
            <td>{{ $invoice->issued_at->format('d M Y') }}</td>
            <td class="text-end">{{ money($invoice->total) }}</td>
            <td class="text-end">{{ money($invoice->balance) }}</td>
            <td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="{{ route('customer.invoices.download', $invoice->uuid) }}">PDF</a></td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-muted text-center py-4">No invoices yet.</td></tr>
    @endforelse
    </tbody>
</table>
{{ $invoices->links() }}
@endsection
