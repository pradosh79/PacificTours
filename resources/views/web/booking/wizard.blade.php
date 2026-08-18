@extends('layouts.app')

{{--
    BOOKING WIZARD — PLACEHOLDER MARKUP, PRODUCTION LOGIC
    Steps: 1 tour · 2 date · 3 guests · 4 details · 5 payment
    All money comes from POST /book/quote so the panel can never disagree with
    what the server charges.
--}}

@section('content')
<div class="container py-4" x-data="bookingWizard({
        step: {{ $step }},
        tourId: {{ $tour->id }},
        quoteUrl: '{{ route('booking.quote') }}',
        state: @js($state)
     })">

    <ol class="wizard-steps list-unstyled d-flex gap-3 mb-4">
        @foreach (['Tour', 'Date', 'Guests', 'Your details', 'Payment'] as $i => $label)
            <li class="flex-fill" :class="{ 'is-done': step > {{ $i + 1 }}, 'is-current': step === {{ $i + 1 }} }">
                <span class="badge rounded-pill text-bg-secondary">{{ $i + 1 }}</span> {{ $label }}
            </li>
        @endforeach
    </ol>

    <form method="POST" action="{{ route('booking.store') }}" @submit="submitting = true">
        @csrf
        <input type="hidden" name="tour_id" :value="form.tour_id">

        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Step 1 & 2 --}}
                <section x-show="step <= 2" class="border rounded p-3 mb-3">
                    <h2 class="h5">{{ $tour->title }}</h2>
                    <label class="form-label">Departure date</label>
                    <select name="tour_departure_id" class="form-select" x-model="form.tour_departure_id" @change="refreshQuote()">
                        @foreach ($tour->departures as $departure)
                            <option value="{{ $departure->id }}" data-date="{{ $departure->start_date->toDateString() }}">
                                {{ $departure->start_date->format('D d M Y') }} — {{ $departure->seats_available }} seats
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="travel_date" :value="form.travel_date">
                </section>

                {{-- Step 3 --}}
                <section x-show="step === 3" class="border rounded p-3 mb-3">
                    <h2 class="h5">Who's travelling?</h2>
                    <div class="row g-2">
                        @foreach (['adults' => 'Adults (12+)', 'children' => 'Children (2–11)', 'infants' => 'Infants (under 2)'] as $field => $label)
                            <div class="col-4">
                                <label class="form-label small">{{ $label }}</label>
                                <input type="number" name="{{ $field }}" min="{{ $field === 'adults' ? 1 : 0 }}"
                                       class="form-control" x-model.number="form.{{ $field }}" @change="refreshQuote()">
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- Step 4 --}}
                <section x-show="step === 4" class="border rounded p-3 mb-3">
                    <h2 class="h5">Lead traveller</h2>
                    <div class="row g-2">
                        <div class="col-md-6"><label class="form-label small">First name</label><input name="customer_first_name" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label small">Last name</label><input name="customer_last_name" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label small">Email</label><input type="email" name="customer_email" class="form-control" value="{{ auth()->user()?->email }}" required></div>
                        <div class="col-md-6"><label class="form-label small">Phone</label><input name="customer_phone" class="form-control" required></div>
                        <div class="col-12"><label class="form-label small">Anything we should know?</label><textarea name="customer_note" rows="3" class="form-control"></textarea></div>
                    </div>

                    <h3 class="h6 mt-4">Traveller names</h3>
                    <template x-for="(traveller, index) in travellers" :key="index">
                        <div class="row g-2 mb-2">
                            <input type="hidden" :name="`travelers[${index}][type]`" :value="traveller.type">
                            <div class="col-md-5"><input :name="`travelers[${index}][first_name]`" class="form-control" placeholder="First name" required></div>
                            <div class="col-md-5"><input :name="`travelers[${index}][last_name]`" class="form-control" placeholder="Last name"></div>
                            <div class="col-md-2 small text-muted align-self-center" x-text="traveller.type"></div>
                        </div>
                    </template>
                </section>

                {{-- Step 5 --}}
                <section x-show="step === 5" class="border rounded p-3 mb-3">
                    <h2 class="h5">Payment</h2>

                    @if ($tour->deposit_type->value !== 'disabled')
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="pay_deposit" value="1"
                                   id="deposit" x-model="form.pay_deposit" @change="refreshQuote()">
                            <label class="form-check-label" for="deposit">Pay a deposit now, balance before departure</label>
                        </div>
                    @endif

                    @foreach ($gateways as $key => $label)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gateway" value="{{ $key }}"
                                   id="gw-{{ $key }}" @checked($loop->first) required>
                            <label class="form-check-label" for="gw-{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach

                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="terms" value="1" id="terms" required x-model="form.terms">
                        <label class="form-check-label" for="terms">
                            I accept the <a href="{{ route('pages.show', 'terms-conditions') }}" target="_blank">booking terms</a>
                            and <a href="{{ route('pages.show', 'cancellation-policy') }}" target="_blank">cancellation policy</a>.
                        </label>
                    </div>
                </section>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" @click="back()" x-show="step > 1">Back</button>
                    <button type="button" class="btn btn-primary ms-auto" @click="next()" x-show="step < 5">Continue</button>
                    <button class="btn btn-primary ms-auto" x-show="step === 5" :disabled="submitting || !form.terms">
                        <span x-show="!submitting">Confirm and pay</span>
                        <span x-show="submitting">Taking you to the payment page…</span>
                    </button>
                </div>
            </div>

            {{-- Live price panel --}}
            <aside class="col-lg-4">
                <div class="border rounded p-3 sticky-top" style="top:1rem">
                    <h2 class="h6">Price summary</h2>
                    <template x-for="line in quote.lines" :key="line.label">
                        <p class="d-flex justify-content-between mb-1 small">
                            <span x-text="line.label"></span><span x-text="format(line.amount)"></span>
                        </p>
                    </template>
                    <hr>
                    <p class="d-flex justify-content-between mb-1 small"><span>Subtotal</span><span x-text="format(quote.subtotal)"></span></p>
                    <p class="d-flex justify-content-between mb-1 small text-success" x-show="quote.tour_discount"><span>Discount</span><span x-text="'−' + format(quote.tour_discount)"></span></p>
                    <p class="d-flex justify-content-between mb-1 small text-success" x-show="quote.coupon?.discount"><span x-text="'Promo ' + quote.coupon.code"></span><span x-text="'−' + format(quote.coupon.discount)"></span></p>
                    <p class="d-flex justify-content-between mb-1 small"><span>Tax</span><span x-text="format(quote.tax)"></span></p>
                    <p class="d-flex justify-content-between fw-bold border-top pt-2"><span>Total</span><span x-text="format(quote.total)"></span></p>
                    <p class="d-flex justify-content-between small text-primary" x-show="quote.deposit"><span>Payable now</span><span x-text="format(quote.payable_now)"></span></p>

                    <div class="input-group input-group-sm mt-3">
                        <input name="coupon_code" class="form-control" placeholder="Promo code" x-model="form.coupon_code">
                        <button type="button" class="btn btn-outline-secondary" @click="refreshQuote()">Apply</button>
                    </div>
                    <p class="small text-danger mt-1" x-show="couponError" x-text="couponError"></p>
                </div>
            </aside>
        </div>
    </form>
</div>
@endsection
