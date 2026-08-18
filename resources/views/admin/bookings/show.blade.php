@extends('layouts.admin')

@section('title', 'Booking '.$booking->booking_number)

@section('actions')
    @can('confirm', $booking)
        <form method="POST" action="{{ route('admin.bookings.confirm', $booking->uuid) }}">@csrf @method('PATCH')
            <button class="btn btn-sm btn-success">Confirm booking</button>
        </form>
    @endcan
    @can('cancel', $booking)
        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancel-modal">Cancel</button>
    @endcan
@endsection

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <section class="panel">
            <header class="panel-head d-flex justify-content-between align-items-center">
                <h2 class="h6 mb-0">{{ $booking->tour->title }}</h2>
                <span class="badge text-bg-{{ $booking->status->badge() }}">{{ $booking->status->label() }}</span>
            </header>
            <dl class="panel-body row mb-0">
                <dt class="col-4">Travel date</dt><dd class="col-8">{{ $booking->travel_date->format('D, d M Y') }}</dd>
                <dt class="col-4">Returns</dt><dd class="col-8">{{ $booking->return_date?->format('D, d M Y') ?? '—' }}</dd>
                <dt class="col-4">Guests</dt><dd class="col-8">{{ $booking->adults }} adults · {{ $booking->children }} children · {{ $booking->infants }} infants</dd>
                <dt class="col-4">Customer</dt><dd class="col-8">{{ $booking->customer_name }} · {{ $booking->customer_email }} · {{ $booking->customer_phone }}</dd>
                <dt class="col-4">Source</dt><dd class="col-8">{{ Str::headline($booking->source) }}</dd>
                <dt class="col-4">Customer note</dt><dd class="col-8">{{ $booking->customer_note ?: '—' }}</dd>
            </dl>
        </section>

        <section class="panel mt-3">
            <header class="panel-head"><h2 class="h6 mb-0">Traveller manifest</h2></header>
            <table class="table table-sm mb-0">
                <thead><tr><th>Type</th><th>Name</th><th>Date of birth</th><th>Passport</th><th>Requests</th></tr></thead>
                <tbody>
                @foreach ($booking->travelers as $traveler)
                    <tr>
                        <td>{{ Str::headline($traveler->type->value) }}</td>
                        <td>{{ $traveler->full_name }}</td>
                        <td>{{ $traveler->date_of_birth?->format('d M Y') ?? '—' }}</td>
                        <td>{{ $traveler->passport_number ?: '—' }}</td>
                        <td>{{ $traveler->special_request ?: '—' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>

        <section class="panel mt-3">
            <header class="panel-head"><h2 class="h6 mb-0">Status history</h2></header>
            <ol class="panel-body list-unstyled mb-0">
                @foreach ($booking->statusHistories as $entry)
                    <li class="border-bottom py-2 small">
                        <strong>{{ Str::headline($entry->to_status) }}</strong>
                        · {{ $entry->created_at->format('d M Y H:i') }}
                        · {{ $entry->user?->full_name ?? 'System' }}
                        @if ($entry->note)<span class="d-block text-muted">{{ $entry->note }}</span>@endif
                    </li>
                @endforeach
            </ol>
        </section>
    </div>

    <div class="col-lg-4">
        <section class="panel">
            <header class="panel-head"><h2 class="h6 mb-0">Money</h2></header>
            <dl class="panel-body row mb-0">
                <dt class="col-7">Subtotal</dt><dd class="col-5 text-end">{{ money($booking->subtotal) }}</dd>
                <dt class="col-7">Tour discount</dt><dd class="col-5 text-end">−{{ money($booking->tour_discount) }}</dd>
                <dt class="col-7">Coupon {{ $booking->coupon?->code }}</dt><dd class="col-5 text-end">−{{ money($booking->coupon_discount) }}</dd>
                <dt class="col-7">Service fee</dt><dd class="col-5 text-end">{{ money($booking->service_fee) }}</dd>
                <dt class="col-7">Tax</dt><dd class="col-5 text-end">{{ money($booking->tax_total) }}</dd>
                <dt class="col-7 fw-bold border-top pt-2">Total</dt><dd class="col-5 text-end fw-bold border-top pt-2">{{ money($booking->grand_total) }}</dd>
                <dt class="col-7 text-success">Paid</dt><dd class="col-5 text-end text-success">{{ money($booking->paid_amount) }}</dd>
                <dt class="col-7 text-danger">Due</dt><dd class="col-5 text-end text-danger">{{ money($booking->due_amount) }}</dd>
            </dl>
        </section>

        @if ($booking->due_amount > 0)
            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Record an office payment</h2></header>
                <form class="panel-body" method="POST" action="{{ route('admin.bookings.payments.store', $booking->uuid) }}">@csrf
                    <div class="mb-2">
                        <label class="form-label small">Amount</label>
                        <input name="amount" type="number" step="0.01" max="{{ $booking->due_amount }}"
                               value="{{ $booking->due_amount }}" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Method</label>
                        <select name="gateway" class="form-select form-select-sm">
                            <option value="cash">Cash / office</option>
                            <option value="bank_transfer">Bank transfer</option>
                            <option value="manual">Other</option>
                        </select>
                    </div>
                    <input name="note" class="form-control form-control-sm mb-2" placeholder="Reference (optional)">
                    <button class="btn btn-sm btn-primary w-100">Record payment</button>
                </form>
            </section>
        @endif

        <section class="panel mt-3">
            <header class="panel-head"><h2 class="h6 mb-0">Payments</h2></header>
            <ul class="panel-body list-unstyled mb-0 small">
                @forelse ($booking->payments as $payment)
                    <li class="d-flex justify-content-between border-bottom py-2">
                        <a href="{{ route('admin.payments.show', $payment->uuid) }}">{{ $payment->gateway->label() }}</a>
                        <span>{{ money($payment->amount) }} · {{ Str::headline($payment->status->value) }}</span>
                    </li>
                @empty
                    <li class="text-muted">No payments recorded.</li>
                @endforelse
            </ul>
        </section>

        <section class="panel mt-3">
            <header class="panel-head"><h2 class="h6 mb-0">Internal note</h2></header>
            <form class="panel-body" method="POST" action="{{ route('admin.bookings.note', $booking->uuid) }}">@csrf @method('PATCH')
                <textarea name="admin_note" rows="4" class="form-control form-control-sm mb-2">{{ $booking->admin_note }}</textarea>
                <button class="btn btn-sm btn-outline-secondary w-100">Save note</button>
            </form>
        </section>
    </div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="cancel-modal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('admin.bookings.cancel', $booking->uuid) }}">
            @csrf @method('PATCH')
            <div class="modal-header"><h5 class="modal-title">Cancel this booking</h5></div>
            <div class="modal-body">
                <p class="small text-muted">Seats return to inventory immediately. Refunds are handled separately from the payment screen.</p>
                <textarea name="reason" rows="3" class="form-control" required placeholder="Reason (shown in the customer email)"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keep booking</button>
                <button class="btn btn-danger">Cancel booking</button>
            </div>
        </form>
    </div>
</div>
@endpush
