@extends('customer.layout')
@section('heading', 'Booking '.$booking->booking_number)

@section('panel')
<div class="d-flex justify-content-between align-items-center mb-3">
    <span class="badge text-bg-{{ $booking->status->badge() }}">{{ $booking->status->label() }}</span>
    <div class="d-flex gap-2">
        @if ($booking->invoice)
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('customer.invoices.download', $booking->invoice->uuid) }}">Download invoice</a>
        @endif
        @can('cancel', $booking)
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancel">Cancel booking</button>
        @endcan
    </div>
</div>

<section class="border rounded p-3 mb-3">
    <h2 class="h6">{{ $booking->tour->title }}</h2>
    <dl class="row small mb-0">
        <dt class="col-5">Departs</dt><dd class="col-7">{{ $booking->travel_date->format('l, d F Y') }}</dd>
        <dt class="col-5">Returns</dt><dd class="col-7">{{ $booking->return_date?->format('l, d F Y') ?? '—' }}</dd>
        <dt class="col-5">Guests</dt><dd class="col-7">{{ $booking->adults }} adults · {{ $booking->children }} children · {{ $booking->infants }} infants</dd>
        @if ($booking->tour->meeting_point)
            <dt class="col-5">Meeting point</dt><dd class="col-7">{{ $booking->tour->meeting_point }}</dd>
        @endif
    </dl>
</section>

<section class="border rounded p-3 mb-3">
    <h2 class="h6">Travellers</h2>
    <ul class="list-unstyled small mb-0">
        @foreach ($booking->travelers as $traveler)
            <li class="border-bottom py-1">{{ $traveler->full_name }} <span class="text-muted">({{ $traveler->type->value }})</span></li>
        @endforeach
    </ul>
</section>

<section class="border rounded p-3 mb-3">
    <h2 class="h6">Payment</h2>
    <dl class="row small mb-0">
        <dt class="col-7">Total</dt><dd class="col-5 text-end">{{ money($booking->grand_total) }}</dd>
        <dt class="col-7 text-success">Paid</dt><dd class="col-5 text-end text-success">{{ money($booking->paid_amount) }}</dd>
        <dt class="col-7 text-danger">Due</dt><dd class="col-5 text-end text-danger">{{ money($booking->due_amount) }}</dd>
    </dl>
    @if ($booking->due_amount > 0)
        <a class="btn btn-sm btn-primary mt-3" href="{{ route('customer.bookings.pay', $booking->uuid) }}">Pay balance</a>
    @endif

    @if ($booking->payments->isNotEmpty())
        <ul class="list-unstyled small mt-3 mb-0">
            @foreach ($booking->payments as $payment)
                <li class="d-flex justify-content-between border-top py-1">
                    <span>{{ $payment->paid_at?->format('d M Y') ?? 'Pending' }} · {{ $payment->gateway->label() }}</span>
                    <span>{{ money($payment->amount) }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</section>

@if ($booking->status === \App\Enums\BookingStatus::Completed && ! $booking->review)
    <section class="border rounded p-3">
        <h2 class="h6">How was it?</h2>
        <form method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tour_id" value="{{ $booking->tour_id }}">
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label small">Rating</label>
                    <select name="rating" class="form-select form-select-sm" required>
                        @for ($i = 5; $i >= 1; $i--)<option value="{{ $i }}">{{ $i }} ★</option>@endfor
                    </select>
                </div>
                <div class="col-md-9"><label class="form-label small">Title</label><input name="title" class="form-control form-control-sm"></div>
                <div class="col-12"><label class="form-label small">Your review</label><textarea name="comment" rows="4" class="form-control form-control-sm" required></textarea></div>
                <div class="col-12"><label class="form-label small">Photos (optional)</label><input type="file" name="images[]" multiple accept="image/*" class="form-control form-control-sm"></div>
            </div>
            <button class="btn btn-sm btn-primary mt-2">Submit review</button>
        </form>
    </section>
@endif
@endsection

@push('scripts')
<div class="modal fade" id="cancel" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('customer.bookings.cancel', $booking->uuid) }}">
            @csrf @method('PATCH')
            <div class="modal-header"><h5 class="modal-title">Cancel this booking</h5></div>
            <div class="modal-body">
                <p class="small text-muted">
                    Refunds follow the cancellation policy for this tour. We'll confirm by email.
                </p>
                <textarea name="reason" rows="3" class="form-control" required placeholder="Tell us why (required)"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keep my booking</button>
                <button class="btn btn-danger">Cancel booking</button>
            </div>
        </form>
    </div>
</div>
@endpush
