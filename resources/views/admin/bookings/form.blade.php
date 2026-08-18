@extends('layouts.admin')
@section('title', 'New booking')

@section('content')
{{-- Staff-entered booking (phone or walk-in). Runs the same BookingService as
     the public wizard, so pricing and seat holding behave identically. --}}
<form method="POST" action="{{ route('admin.bookings.store') }}" class="row g-3">
    @csrf
    <div class="col-lg-8">
        <section class="panel">
            <header class="panel-head"><h2 class="h6 mb-0">Tour &amp; date</h2></header>
            <div class="panel-body row g-2">
                <div class="col-md-6">
                    <label class="form-label small">Tour</label>
                    <select name="tour_id" class="form-select" required>
                        <option value="">Choose a tour</option>
                        @foreach ($tours as $tour)
                            <option value="{{ $tour->id }}" @selected(old('tour_id') == $tour->id)>{{ $tour->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Travel date</label>
                    <input type="date" name="travel_date" class="form-control" value="{{ old('travel_date') }}" min="{{ now()->toDateString() }}" required>
                </div>
                <div class="col-md-4"><label class="form-label small">Adults</label><input type="number" name="adults" min="1" value="{{ old('adults', 1) }}" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label small">Children</label><input type="number" name="children" min="0" value="{{ old('children', 0) }}" class="form-control"></div>
                <div class="col-md-4"><label class="form-label small">Infants</label><input type="number" name="infants" min="0" value="{{ old('infants', 0) }}" class="form-control"></div>
            </div>
        </section>

        <section class="panel mt-3">
            <header class="panel-head"><h2 class="h6 mb-0">Customer</h2></header>
            <div class="panel-body row g-2">
                <div class="col-md-6"><label class="form-label small">First name</label><input name="customer_first_name" class="form-control" value="{{ old('customer_first_name') }}" required></div>
                <div class="col-md-6"><label class="form-label small">Last name</label><input name="customer_last_name" class="form-control" value="{{ old('customer_last_name') }}"></div>
                <div class="col-md-6"><label class="form-label small">Email</label><input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" required></div>
                <div class="col-md-6"><label class="form-label small">Phone</label><input name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" required></div>
                <div class="col-12"><label class="form-label small">Address</label><textarea name="customer_address" rows="2" class="form-control">{{ old('customer_address') }}</textarea></div>
                <div class="col-12"><label class="form-label small">Internal note</label><textarea name="admin_note" rows="2" class="form-control">{{ old('admin_note') }}</textarea></div>
            </div>
        </section>
    </div>

    <div class="col-lg-4">
        <section class="panel">
            <header class="panel-head"><h2 class="h6 mb-0">Pricing</h2></header>
            <div class="panel-body">
                <label class="form-label small">Promo code</label>
                <input name="coupon_code" class="form-control mb-3" value="{{ old('coupon_code') }}">

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="pay_deposit" value="1" id="dep" @checked(old('pay_deposit'))>
                    <label class="form-check-label small" for="dep">Deposit only</label>
                </div>

                <p class="small text-muted">
                    Totals are calculated server-side when the booking is created — the customer
                    receives the same figures the wizard would have quoted.
                </p>

                <button class="btn btn-primary w-100">Create booking</button>
            </div>
        </section>
    </div>
</form>
@endsection
