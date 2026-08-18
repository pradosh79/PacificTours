@extends('layouts.admin')
@section('title', 'Payments')

@section('content')
<div class="panel">
    <header class="panel-head">
        <form class="d-flex flex-wrap gap-2">
            <input name="keyword" class="form-control form-control-sm w-auto" placeholder="Transaction or booking" value="{{ request('keyword') }}">
            <select name="gateway" class="form-select form-select-sm w-auto">
                <option value="">All gateways</option>
                @foreach (\App\Enums\PaymentGateway::cases() as $gateway)
                    <option value="{{ $gateway->value }}" @selected(request('gateway') === $gateway->value)>{{ $gateway->label() }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm w-auto">
                <option value="">Any status</option>
                @foreach (\App\Enums\TransactionStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ Str::headline($status->value) }}</option>
                @endforeach
            </select>
            <input type="date" name="date_from" class="form-control form-control-sm w-auto" value="{{ request('date_from') }}">
            <input type="date" name="date_to" class="form-control form-control-sm w-auto" value="{{ request('date_to') }}">
            <button class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>
    </header>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead><tr><th>Date</th><th>Booking</th><th>Gateway</th><th>Type</th><th class="text-end">Amount</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ ($payment->paid_at ?? $payment->created_at)->format('d M Y H:i') }}</td>
                    <td><a href="{{ route('admin.bookings.show', $payment->booking->uuid) }}">{{ $payment->booking->booking_number }}</a></td>
                    <td>{{ $payment->gateway->label() }}</td>
                    <td>{{ Str::headline($payment->type->value) }}</td>
                    <td class="text-end">{{ money($payment->amount) }}</td>
                    <td><span class="badge text-bg-{{ $payment->status->badge() }}">{{ Str::headline($payment->status->value) }}</span></td>
                    <td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.payments.show', $payment->uuid) }}">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">No payments match this filter.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="panel-foot d-flex justify-content-between align-items-center">
        <span class="small text-muted">Total shown: {{ money($payments->sum('amount')) }}</span>
        {{ $payments->withQueryString()->links() }}
    </div>
</div>
@endsection
