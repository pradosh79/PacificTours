@extends('layouts.app')

{{-- PLACEHOLDER VIEW — replaced by the Figma design. Variable contract: $tour, $related --}}

@section('content')
<article class="container py-4" itemscope itemtype="https://schema.org/TouristTrip">
    <nav aria-label="Breadcrumb" class="small mb-3">
        <a href="{{ route('home') }}">Home</a> ›
        <a href="{{ route('tours.index') }}">Tours</a> ›
        <span>{{ $tour->title }}</span>
    </nav>

    <header class="mb-4">
        <h1 itemprop="name">{{ $tour->t('title') }}</h1>
        <p class="text-muted">
            {{ $tour->destination?->name }} · {{ $tour->duration_days }} days / {{ $tour->duration_nights }} nights
            · {{ number_format((float) $tour->average_rating, 1) }}/5 from {{ $tour->reviews_count }} reviews
        </p>
    </header>

    <div class="row g-4">
        <div class="col-lg-8">
            <img src="{{ upload_url($tour->banner ?: $tour->thumbnail) }}" alt="{{ $tour->title }}" class="img-fluid rounded mb-4">

            <section class="mb-4">
                <h2 class="h5">Overview</h2>
                <div>{!! $tour->t('description') !!}</div>
            </section>

            @if ($tour->highlights->isNotEmpty())
                <section class="mb-4">
                    <h2 class="h5">Highlights</h2>
                    <ul>@foreach ($tour->highlights as $highlight)<li>{{ $highlight->content }}</li>@endforeach</ul>
                </section>
            @endif

            <section class="mb-4">
                <h2 class="h5">Itinerary</h2>
                <div class="accordion" id="itinerary">
                    @foreach ($tour->itineraries as $day)
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#day-{{ $day->day_number }}">
                                    Day {{ $day->day_number }} · {{ $day->title }}
                                </button>
                            </h3>
                            <div id="day-{{ $day->day_number }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#itinerary">
                                <div class="accordion-body">
                                    {!! $day->description !!}
                                    @if ($day->accommodation)<p class="small text-muted mb-0">Stay: {{ $day->accommodation }} · Meals: {{ $day->meals }}</p>@endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="row">
                <section class="col-md-6 mb-4">
                    <h2 class="h5">What's included</h2>
                    <ul>@foreach ($tour->inclusions->where('type', 'included') as $line)<li>{{ $line->content }}</li>@endforeach</ul>
                </section>
                <section class="col-md-6 mb-4">
                    <h2 class="h5">Not included</h2>
                    <ul>@foreach ($tour->inclusions->where('type', 'excluded') as $line)<li>{{ $line->content }}</li>@endforeach</ul>
                </section>
            </div>

            @foreach (['travel_information' => 'Travel information', 'visa_requirements' => 'Visa requirements', 'cancellation_policy' => 'Cancellation policy', 'terms_and_conditions' => 'Terms'] as $field => $heading)
                @if ($tour->{$field})
                    <section class="mb-4"><h2 class="h5">{{ $heading }}</h2><div>{!! $tour->{$field} !!}</div></section>
                @endif
            @endforeach

            <section class="mb-4">
                <h2 class="h5">Reviews</h2>
                @forelse ($tour->approvedReviews as $review)
                    <article class="border-bottom py-3">
                        <p class="mb-1"><strong>{{ $review->reviewer_name }}</strong> · {{ $review->rating }}/5
                            @if ($review->is_verified_purchase)<span class="badge text-bg-light">Verified traveller</span>@endif
                        </p>
                        <p class="mb-0">{{ $review->comment }}</p>
                    </article>
                @empty
                    <p class="text-muted">No reviews yet.</p>
                @endforelse
            </section>
        </div>

        {{-- Booking panel: posts into the wizard at step 3 --}}
        <aside class="col-lg-4">
            <div class="border rounded p-3 sticky-top" style="top: 1rem">
                <p class="h4 mb-1">{{ money($tour->sale_price) }} <span class="fs-6 text-muted">per adult</span></p>
                @if ($tour->hasDiscount())
                    <p class="text-muted"><s>{{ money($tour->base_price) }}</s> save {{ money($tour->discountAmount()) }}</p>
                @endif

                <form method="GET" action="{{ route('booking.start', $tour->slug) }}">
                    <label class="form-label small">Departure date</label>
                    <select name="tour_departure_id" class="form-select mb-2" required>
                        @forelse ($tour->departures as $departure)
                            <option value="{{ $departure->id }}">
                                {{ $departure->start_date->format('D d M Y') }} · {{ $departure->seats_available }} seats left
                            </option>
                        @empty
                            <option disabled>No dates open — contact us for a private departure</option>
                        @endforelse
                    </select>

                    <div class="row g-2 mb-3">
                        <div class="col-4"><label class="form-label small">Adults</label><input type="number" name="adults" min="1" value="1" class="form-control"></div>
                        <div class="col-4"><label class="form-label small">Children</label><input type="number" name="children" min="0" value="0" class="form-control"></div>
                        <div class="col-4"><label class="form-label small">Infants</label><input type="number" name="infants" min="0" value="0" class="form-control"></div>
                    </div>

                    <button class="btn btn-primary w-100">Check availability</button>
                </form>

                @auth
                    <button class="btn btn-link w-100 mt-2" data-wishlist="{{ route('customer.wishlist.toggle', $tour->uuid) }}">Save for later</button>
                @endauth
            </div>
        </aside>
    </div>
</article>
@endsection
