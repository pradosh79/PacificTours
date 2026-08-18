@extends('layouts.admin')
@section('title', 'Payment detail')

@section('content')
<div class="row g-3">
    <div class="col-lg-7">
        <section class="panel">
            <header class="panel-head d-flex justify-content-between">
                <h2 class="h6 mb-0">{{ $payment->gateway->label() }} · {{ money($payment->amount) }}</h2>
                <span class="badge text-bg-{{ $payment->status->badge() }}">{{ Str::headline($payment->status->value) }}</span>
            </header>
            <dl class="panel-body row mb-0 small">
                <dt class="col-4">Booking</dt><dd class="col-8"><a href="{{ route('admin.bookings.show', $payment->booking->uuid) }}">{{ $payment->booking->booking_number }}</a></dd>
                <dt class="col-4">Type</dt><dd class="col-8">{{ Str::headline($payment->type->value) }}</dd>
                <dt class="col-4">Transaction ID</dt><dd class="col-8"><code>{{ $payment->transaction_id ?: '—' }}</code></dd>
                <dt class="col-4">Gateway reference</dt><dd class="col-8"><code>{{ $payment->gateway_reference ?: '—' }}</code></dd>
                <dt class="col-4">Paid at</dt><dd class="col-8">{{ $payment->paid_at?->format('d M Y H:i') ?? '—' }}</dd>
                <dt class="col-4">Recorded by</dt><dd class="col-8">{{ $payment->recorder?->full_name ?? 'Gateway' }}</dd>
                @if ($payment->failure_reason)
                    <dt class="col-4 text-danger">Failure</dt><dd class="col-8 text-danger">{{ $payment->failure_reason }}</dd>
                @endif
            </dl>
        </section>

        <section class="panel mt-3">
            <header class="panel-head"><h2 class="h6 mb-0">Gateway log</h2></header>
            <ul class="panel-body list-unstyled mb-0 small">
                @forelse ($payment->logs as $log)
                    <li class="border-bottom py-2">
                        <strong>{{ $log->event }}</strong>
                        <span class="text-muted">· {{ $log->created_at->format('d M Y H:i:s') }}</span>
                        @if ($log->context)
                            <pre class="small bg-light p-2 mt-1 mb-0" style="max-height:12rem;overflow:auto">{{ json_encode($log->context, JSON_PRETTY_PRINT) }}</pre>
                        @endif
                    </li>
                @empty
                    <li class="text-muted">No log entries.</li>
                @endforelse
            </ul>
        </section>
    </div>

    <div class="col-lg-5">
        @if ($payment->refundable_amount > 0)
            @can('refund', $payment->booking)
                <section class="panel">
                    <header class="panel-head"><h2 class="h6 mb-0">Issue a refund</h2></header>
                    <form class="panel-body" method="POST" action="{{ route('admin.payments.refund', $payment->uuid) }}">
                        @csrf
                        <p class="small text-muted">Refundable: {{ money($payment->refundable_amount) }}</p>
                        <label class="form-label small">Amount</label>
                        <input type="number" step="0.01" name="amount" max="{{ $payment->refundable_amount }}"
                               value="{{ $payment->refundable_amount }}" class="form-control form-control-sm mb-2" required>
                        <label class="form-label small">Reason</label>
                        <textarea name="reason" rows="3" class="form-control form-control-sm mb-2" required></textarea>
                        <button class="btn btn-sm btn-danger w-100"
                                onclick="return confirm('Refund this amount through {{ $payment->gateway->label() }}?')">
                            Refund
                        </button>
                    </form>
                </section>
            @endcan
        @endif

        @if ($payment->refunds->isNotEmpty())
            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Refunds</h2></header>
                <ul class="panel-body list-unstyled mb-0 small">
                    @foreach ($payment->refunds as $refund)
                        <li class="border-bottom py-2 d-flex justify-content-between">
                            <span>{{ $refund->processed_at?->format('d M Y') }} · {{ $refund->reason }}</span>
                            <span>{{ money($refund->amount) }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</div>
@endsection
