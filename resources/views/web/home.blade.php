@extends('layouts.app')

@php
    /*
     * Every setting() call ships a real fallback so the page renders correctly
     * whether or not the SettingSeeder has been run. Editors can override any
     * of these at Admin → Settings → Home page content.
     */
    $hero = [
        'lead'    => setting('home.hero_title_lead',   'Explore'),
        'accent'  => setting('home.hero_title_accent', 'British Colombia'),
        'trail'   => setting('home.hero_title_trail',  'with Pacific Tours'),
        'sub'     => setting('home.hero_subtitle',     'Discover Vancouver, Whistler, Victoria and the lower Mainland in comfort aboard our premium Mercedes-Benz Sprinter'),
        'cta'     => setting('home.hero_cta_label',    'Explore Packages'),
        'bg'      => setting('home.hero_bg'),
        'phone'   => setting('general.company_phone',  '6043581236'),
    ];

    $fleetFeatures = (array) setting('home.fleet_features', [
        'High Roof Design', 'Air Conditioning', 'Comfortable Seating',
        'Large Windows', 'Panoramic Views', 'Luggage Capacity',
        'Professional Maintenance', 'Modern Safety Features',
    ]);

    // Default map: 28 East 19th Avenue, Vancouver
    $mapEmbed = setting('home.map_embed_url',
        'https://maps.google.com/maps?q=28+East+19th+Avenue+Vancouver+BC&t=&z=15&ie=UTF8&iwloc=&output=embed');
@endphp

@section('content')

{{-- 1. HERO ------------------------------------------------------------- --}}
@php
    $heroImage = $hero['bg']
        ? upload_url($hero['bg'])
        : asset('images/hero-default.svg');
@endphp
<section class="pt-hero"
         style="background-image: linear-gradient(90deg, rgba(6,20,32,.75), rgba(6,20,32,.15) 55%, transparent 80%), url('{{ $heroImage }}')">
    <div class="container">
        <div class="pt-hero__inner">
            <h1 class="pt-hero__title">
                {{ $hero['lead'] }} <span class="text-accent">{{ $hero['accent'] }}</span><br>
                {{ $hero['trail'] }}
            </h1>
            @if ($hero['sub'])<p class="pt-hero__sub">{{ $hero['sub'] }}</p>@endif

            <div class="pt-hero__cta">
                <a href="{{ route('tours.index') }}" class="btn-pill btn-pill--primary">{{ $hero['cta'] }}</a>
                @if ($hero['phone'])
                    <a href="tel:{{ preg_replace('/\D/', '', $hero['phone']) }}" class="btn-pill btn-pill--ghost">
                        <x-icon name="phone" width="14" height="14" /> {{ $hero['phone'] }}
                    </a>
                @endif
            </div>

            {{-- Account CTA: shows either "Create account / Log in" or "Welcome back, name / Dashboard" --}}
            @guest
                <div class="pt-hero__account">
                    <a href="{{ route('register') }}" class="pt-hero__account-cta">
                        <x-icon name="user" width="14" height="14" /> Create An Account
                    </a>
                    <span>Already have an account? <a href="{{ route('login') }}">Log in</a></span>
                </div>
            @else
                <div class="pt-hero__account">
                    <a href="{{ route('customer.dashboard') }}" class="pt-hero__account-cta">
                        <x-icon name="user" width="14" height="14" /> My Dashboard
                    </a>
                    <span>Welcome back, {{ auth()->user()->first_name ?? auth()->user()->name }}</span>
                </div>
            @endguest
        </div>
    </div>
</section>

{{-- 2. QUOTE SEARCH BAND ----------------------------------------------- --}}
<section class="pt-quote">
    <div class="container">
        <h2 class="pt-quote__lead">
            Discover Vancouver, Whistler, Victoria and the lower Mainland<br class="d-none d-md-block">
            in comfort abroad our premium Mercedes-Benz Sprinter
        </h2>
        <div class="pt-quote__tab"><a href="{{ route('tours.index') }}">{{ $hero['cta'] }}</a></div>

        <form class="pt-quote__form" action="{{ route('tours.index') }}" method="GET">
            <label class="pt-quote__field">
                <span class="pt-quote__label">Select Location</span>
                <select name="destination">
                    <option value="">Select Location</option>
                    @foreach ($destinations as $destination)
                        <option value="{{ $destination->slug }}">{{ $destination->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="pt-quote__field">
                <span class="pt-quote__label"><x-icon name="calendar" width="12" height="12" /> Date &amp; Time</span>
                <input type="date" name="travel_date" value="{{ now()->addDays(3)->toDateString() }}" min="{{ now()->toDateString() }}">
            </label>

            <label class="pt-quote__field">
                <span class="pt-quote__label">No. of Person (Minimum 5 Persons)</span>
                <input type="number" name="guests" min="1" placeholder="Add Additional Guests">
            </label>

            <button class="btn-pill btn-pill--primary pt-quote__submit">Request A Quote</button>
        </form>
    </div>
</section>

{{-- 3. SECTION TITLE ---------------------------------------------------- --}}
<section class="pt-section pt-section--intro">
    <div class="container text-center">
        <h2 class="pt-section__title">{{ setting('home.section_title', 'Explore British Columbia in Comfort') }}</h2>
        <span class="pt-section__underline"></span>
    </div>
</section>

{{-- 4. POPULAR DESTINATIONS -------------------------------------------- --}}
<section class="pt-destinations">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5">
                <!--<h3 class="pt-destinations__heading text-accent">-->
                <!--    {{ setting('home.destinations_heading', 'Popular Destinations') }}-->
                <!--</h3>-->
                @php
                    $heading = setting('home.destinations_heading', 'Popular Destinations');
                    $words = explode(' ', $heading);
                @endphp
                
                <h3 class="pt-destinations__heading">
                    <span class="heading-black">
                        {{ implode(' ', array_slice($words, 0, 1)) }}
                    </span>
                    <span class="text-accent">
                        {{ implode(' ', array_slice($words, 1)) }}
                    </span>
                </h3>
                <p class="pt-destinations__intro">
                    {{ setting('home.destinations_intro', 'These are professionally structured carrier-directed sightseeing tours for Pacific Tours using our premium 12-passenger Mercedes-Benz Sprinter. Explore the breathtaking beauty of British Columbia through our carefully curated local tours and sightseeing experiences.') }}
                </p>
                <a href="{{ route('destinations.index') }}" class="btn-pill btn-pill--primary">View All Destinations</a>

                @if (setting('home.sprinter_image'))
                    <img src="{{ upload_url(setting('home.sprinter_image')) }}"
                         alt="Mercedes-Benz Sprinter"
                         class="pt-destinations__van d-none d-lg-block" loading="lazy">
                @endif
            </div>

            <div class="col-lg-7">
                <!--<div class="pt-destinations__grid">-->
                <!--    @forelse ($popularDestinations as $destination)-->
                <!--        <a href="{{ route('destinations.show', $destination->slug) }}" class="pt-dest-card">-->
                <!--            <img src="{{ upload_url($destination->thumbnail) }}" alt="{{ $destination->name }}" loading="lazy">-->
                <!--            <div class="pt-dest-card__body">-->
                <!--                <h4 class="pt-dest-card__title">{{ $destination->name }}</h4>-->
                <!--                <p class="pt-dest-card__meta">{{ $destination->short_description ?: 'Mountains · Ocean · Suspension Bridges' }}</p>-->
                <!--                <span class="pt-dest-card__price">-->
                <!--                    @if ($destination->from_price ?? null)${{ number_format($destination->from_price, 0) }}/Person @endif-->
                <!--                </span>-->
                <!--                <div class="pt-dest-card__foot">-->
                <!--                    <span class="pt-dest-card__hours">-->
                <!--                        <x-icon name="clock" width="12" height="12" />-->
                <!--                        {{ ($destination->duration_hours ?? 8) }} hr Tour-->
                <!--                    </span>-->
                <!--                    <span class="pt-dest-card__more">Read More <x-icon name="arrow-right" width="12" height="12" /></span>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </a>-->
                <!--    @empty-->
                <!--        <p class="text-muted col-12">No destinations published yet.</p>-->
                <!--    @endforelse-->
                <!--</div>-->
                
                <div class="tour-grid">
                    @forelse ($popularDestinations->take(4) as $destination)
                        <a href="{{ route('destinations.show', $destination->slug) }}"
                           class="tour-card tour-card-{{ $loop->iteration }}">
                
                            <div class="tour-content">
                                <h3>
                                    {{ $destination->name }}
                                </h3>
                
                                <p class="tour-description">
                                    {{ $destination->short_description ?: 'Mountains · Ocean · Suspension Bridges' }}
                                </p>
                
                                @if ($destination->from_price ?? null)
                                    <div class="tour-price">
                                        ${{ number_format($destination->from_price, 0) }}/Person
                                        <span>(5 person group minimum)</span>
                                    </div>
                                @endif
                
                                <div class="tour-bottom">
                
                                    <div class="tour-duration">
                                        <span class="clock-icon">
                                            <x-icon name="clock" width="12" height="12" />
                                        </span>
                
                                        {{ $destination->duration_hours ?? 8 }} hr Tour
                                    </div>
                
                                    <span class="read-more">
                                        Read More
                                        <span>→</span>
                                    </span>
                
                                </div>
                
                            </div>
                
                            <div class="tour-image">
                                <img
                                    src="{{ upload_url($destination->thumbnail) }}"
                                    alt="{{ $destination->name }}"
                                    loading="lazy"
                                >
                            </div>
                
                        </a>
                
                    @empty
                
                        <p class="text-muted col-12">
                            No destinations published yet.
                        </p>
                
                    @endforelse
                
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 5. FEATURED TOUR PACKAGES ------------------------------------------ --}}
<section class="pt-featured">
    <div class="container">
        <div class="pt-featured__head">
            <div>
                <!--<h3 class="pt-featured__heading text-accent">-->
                <!--    {{ setting('home.featured_heading', 'Featured Tour Packages') }}-->
                <!--</h3>-->
                @php
                    $heading = setting('home.featured_heading', 'Featured Tour Packages');
                    $words = explode(' ', $heading);
                @endphp
                
                <h3 class="pt-section__title">
                    <span class="heading-black">
                        {{ implode(' ', array_slice($words, 0, 1)) }}
                    </span>
                    <span class="text-accent">
                        {{ implode(' ', array_slice($words, 1)) }}
                    </span>
                </h3>
                <p class="pt-featured__intro">
                    {{ setting('home.featured_intro', 'These are professionally structured carrier-directed sightseeing tours for Pacific Tours using our premium 12-passenger Mercedes-Benz Sprinter. Explore the breathtaking beauty of British Columbia through our carefully curated local tours and sightseeing experiences.') }}
                </p>
            </div>
            <a href="{{ route('tours.index') }}" class="btn-pill btn-pill--primary">Explore Tours</a>
        </div>

        <div class="pt-featured__carousel" data-carousel>
            <button class="pt-featured__arrow pt-featured__arrow--prev" type="button" data-carousel-prev aria-label="Previous">
                <x-icon name="chevron-left" />
            </button>
            <div class="pt-featured__track" data-carousel-track>
                @forelse ($featuredTours as $tour)
                    <a href="{{ route('tours.show', $tour->slug) }}" class="pt-tour-card">
                        <img src="{{ upload_url($tour->thumbnail) }}" alt="{{ $tour->title }}" loading="lazy">
                        <div class="pt-tour-card__body">
                            <h4>{{ $tour->title }}</h4>
                            <div class="pt-tour-card__foot">
                                <p class="pt-tour-card__price">
                                    @if ($tour->hasDiscount())${{ number_format($tour->sale_price ?? $tour->base_price, 0) }}
                                    @else${{ number_format($tour->base_price, 0) }}@endif/Person
                                </p>
                                <span><x-icon name="clock" width="12" height="12" /> {{ ($tour->duration_days ?? 1) * 8 }} hrs Tour</span>
                            </div>
                            <span class="pt-tour-card__cta">Explore <x-icon name="arrow-right" width="12" height="12" /></span>
                        </div>
                    </a>
                @empty
                    <p class="text-muted">No featured tours yet.</p>
                @endforelse
            </div>
            <button class="pt-featured__arrow pt-featured__arrow--next" type="button" data-carousel-next aria-label="Next">
                <x-icon name="chevron-right" />
            </button>
        </div>
    </div>
</section>

{{-- 6. WHY PACIFIC TOURS ------------------------------------------------ --}}
@php
    // Fallback tiles so the section is never empty. Admin edits these at
    // Admin → Home features once real content is ready.
    $features = $homeFeatures ?? collect();
    if ($features->isEmpty()) {
        $features = collect([
            ['icon' => 'users',  'title' => 'Small Group Experience',
             'description' => 'Travel in small groups for a more personal, relaxed, and enjoyable tour experience with dedicated attention from our local guides.'],
            ['icon' => 'award',  'title' => 'Private Custom Tours',
             'description' => 'We can create a personalised British Columbia sightseeing itinerary tailored to your interests, schedule and pace.'],
            ['icon' => 'shield', 'title' => 'Safe & Reliable',
             'description' => 'Travel with confidence through trusted guides, comfortable transportation, and reliable service, every time.'],
            ['icon' => 'anchor', 'title' => 'Cruise Passenger Excursions',
             'description' => 'Convenient sightseeing tours designed for cruise ship visitors arriving in Vancouver who want to maximise their time exploring British Columbia.'],
            ['icon' => 'clock',  'title' => 'Flexible Service',
             'description' => 'Ideal for families, visitors, cruise passengers, and corporate groups.'],
            ['icon' => 'car',    'title' => 'Mercedes-Benz Sprinter transportation',
             'description' => 'Professional commercial driver with extensive BC experience.'],
        ])->map(fn ($x) => (object) $x);
    }
@endphp
<section class="pt-why">
    <div class="container">
        <div class="text-left mb-4">
            <!--<h3 class="pt-section__title">-->
            <!--    {{ setting('home.why_heading', 'Why Pacific Tours Is the Best Place to Book') }}-->
            <!--</h3>-->
            @php
                $heading = setting('home.why_heading', 'Why Pacific Tours Is the Best Place to Book');
                $words = explode(' ', $heading);
            @endphp
            
            <h3 class="pt-section__title">
                <span class="heading-black">
                    {{ implode(' ', array_slice($words, 0, 5)) }}
                </span>
                <span class="text-accent">
                    {{ implode(' ', array_slice($words, 5)) }}
                </span>
            </h3>
            <p class="pt-why__intro">
                {{ setting('home.why_intro', 'Book directly with British Columbia tour specialists for better value, local knowledge, and a seamless travel experience.') }}
            </p>
        </div>

        <div class="row custom-class">
            <!--@foreach ($features as $feature)-->
            <!--    <div class="col-md-5">-->
            <!--        <article class="pt-why-tile">-->
            <!--            <span class="pt-why-tile__icon">-->
            <!--                @if ($feature->image ?? null)-->
            <!--                    {{-- Admin uploaded a custom image — use it in place of a named icon. --}}-->
            <!--                    <img src="{{ upload_url($feature->image) }}" alt="" style="width:22px;height:22px;object-fit:contain">-->
            <!--                @else-->
            <!--                    <x-icon :name="$feature->icon ?? 'check'" width="22" height="22" />-->
            <!--                @endif-->
            <!--            </span>-->
            <!--            <div>-->
            <!--                <h4 class="pt-why-tile__title">{{ $feature->title }}</h4>-->
            <!--                @if ($feature->description ?? null)-->
            <!--                    <p class="pt-why-tile__desc">{{ $feature->description }}</p>-->
            <!--                @endif-->
            <!--            </div>-->
            <!--        </article>-->
            <!--    </div>-->
            <!--@endforeach-->
            
            @foreach ($features as $feature)
                <div class="col-md-5">
                    <article class="pt-why-tile">
                        <div class="pt-why-tile__header">
                            <span class="pt-why-tile__icon">
                                @if ($feature->image ?? null)
                                    {{-- Admin uploaded a custom image — use it in place of a named icon. --}}
                                   <img src="{{ upload_url($feature->image) }}" alt="" style="object-fit:contain">
                                @else
                                  <x-icon :name="$feature->icon ?? 'check'" width="22" height="22" />
                               @endif
                          </span>
                            <h4 class="pt-why-tile__title">{{ $feature->title }}</h4>
                        </div>
                        @if ($feature->description ?? null)
                            <p class="pt-why-tile__desc">{{ $feature->description }}</p>
                        @endif
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 7. TESTIMONIALS ---------------------------------------------------- --}}
@php
    /*
     * Circular carousel needs at least four testimonials to fill front /
     * peek / left / right without a card doubling up. If fewer are available,
     * pad the collection by repeating from the start — the JS role math still
     * works and the visitor sees the same testimonial in more than one slot,
     * which is preferable to empty slots.
     */
    $stories = $testimonials;
    if ($stories->count() > 0 && $stories->count() < 4) {
        while ($stories->count() < 4) {
            $stories = $stories->merge($testimonials);
        }
        $stories = $stories->take(4);
    }
@endphp
<section class="pt-testimonials">
    <div class="container">
        <div class="pt-testimonials__head text-center mb-4">
            <h3 class="pt-testimonials__title">
                {!! preg_replace('/^(\S+\s\S+)\s(.*)$/', '$1 <span class="text-accent">$2</span>',
                        e(setting('home.testimonials_heading', 'Real People Real Stories'))) !!}
            </h3>
            <p class="pt-testimonials__intro">
                {{ setting('home.testimonials_intro', 'Hear from travellers who have explored British Columbia with Pacific Tours. Their genuine experiences and memorable journeys reflect the quality, comfort, and care we bring to every tour.') }}
            </p>
        </div>

        @if ($stories->isEmpty())
            <p class="text-muted text-center">No stories published yet.</p>
        @else
            <div class="pt-testimonials__carousel" data-testimonials-carousel>
                {{-- Stage: every card is absolutely positioned; the JS assigns roles that
                     translate/scale each card into the front / peek / left / right / hidden
                     slot based on its distance from the active index. --}}
                <div class="pt-testimonials__stage">
                    @foreach ($stories as $i => $t)
                        <article class="pt-story-card" data-story-index="{{ $i }}">
                            <img src="{{ upload_url($t->avatar, 'images/avatar-placeholder.png') }}"
                                     alt="{{ $t->name }}" class="pt-story-card__avatar" loading="lazy">
                            <header class="pt-story-card__head">
                                <div>
                                    <p class="pt-story-card__name">{{ $t->name }}</p>
                                    <div class="pt-story-card__stars"
                                         aria-label="{{ $t->rating }} out of 5 stars">
                                        {{ str_repeat('★', (int) $t->rating) }}{{ str_repeat('☆', 5 - (int) $t->rating) }}
                                    </div>
                                </div>
                                <p class="pt-story-card__body">{{ $t->content }}</p>
                            </header>
                        </article>
                    @endforeach
                </div>

                <div class="pt-testimonials__controls">
                    <button class="pt-testimonials__arrow prev" type="button"
                            data-story-prev aria-label="Previous testimonial">
                        <x-icon name="chevron-left" width="16" height="16" />
                    </button>
                    <div class="pt-testimonials__dots">
                        @foreach ($stories as $i => $t)
                            <button type="button" class="pt-testimonials__dot"
                                    data-story-dot="{{ $i }}"
                                    aria-label="Show testimonial {{ $i + 1 }}"></button>
                        @endforeach
                    </div>
                    <button class="pt-testimonials__arrow next" type="button"
                            data-story-next aria-label="Next testimonial">
                        <x-icon name="chevron-right" width="16" height="16" />
                    </button>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- 8. FLEET / SPRINTER BAND -------------------------------------------- --}}
<section class="pt-fleet"
         @if (setting('home.fleet_bg')) style="background-image:url('{{ upload_url(setting('home.fleet_bg')) }}')" @endif>
    <div class="container text-center">
        <h3 class="pt-fleet__heading">
            {{ setting('home.fleet_heading', 'Comfortable Mercedes-Benz Sprinter transportation') }}
        </h3>

        @if ($fleetFeatures)
            <p class="pt-fleet__list">
                @foreach ($fleetFeatures as $i => $feature)
                    <span>{{ $feature }}</span>@if ($i < count($fleetFeatures) - 1) <span class="pt-fleet__dot">•</span> @endif
                @endforeach
            </p>
        @endif

        <div class="pt-fleet__cta">
            <a href="{{ route('tours.index') }}" class="btn-pill btn-pill--primary">Book Now</a>
            @if ($hero['phone'])
                <a href="tel:{{ preg_replace('/\D/', '', $hero['phone']) }}" class="btn-pill btn-pill--white">
                    <x-icon name="phone" width="14" height="14" /> {{ $hero['phone'] }}
                </a>
            @endif
        </div>
    </div>
</section>

{{-- 9. CONTACT + MAP --------------------------------------------------- --}}
<section class="pt-contact">
    <div class="pt-contact__grid">
        <div class="pt-contact__form">
            <h3>{{ setting('home.contact_heading', 'Contact Us') }}</h3>
            <p>{{ setting('home.contact_intro', 'Pacific Tours is a Vancouver-based sightseeing tour operator specialising in professionally operated carrier-directed sightseeing tours throughout British Columbia.') }}</p>

            <form action="{{ route('contact.submit') }}" method="POST" class="pt-contact__fields">
                @csrf
                {{-- Honeypot: real people never fill this in --}}
                <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off">

                <div class="row g-2">
                    <div class="col-sm-6"><input name="first_name" type="text" placeholder="First Name*" required></div>
                    <div class="col-sm-6"><input name="last_name" type="text" placeholder="Last Name"></div>
                    <div class="col-sm-6"><input name="phone" type="tel" placeholder="Contact Number*" required></div>
                    <div class="col-sm-6"><input name="email" type="email" placeholder="E-Mail Address*" required></div>
                    <div class="col-12">
                        <select name="destination">
                            <option value="">Location you want to explore</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->slug }}">{{ $destination->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12"><textarea name="message" rows="4" placeholder="Message…" required></textarea></div>
                </div>

                <button type="submit" class="pt-contact__submit">Submit</button>
            </form>
        </div>

        <div class="pt-contact__map">
            <iframe src="{{ $mapEmbed }}" loading="lazy" allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Pacific Tours office location"></iframe>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    /* Featured-tours horizontal carousel — width-based scroll, works on any tour count. */
    document.querySelectorAll('[data-carousel]').forEach(root => {
        const track = root.querySelector('[data-carousel-track]');
        const step = () => (track.querySelector('.pt-tour-card')?.offsetWidth || 260) + 16;
        root.querySelector('[data-carousel-prev]')?.addEventListener('click',
            () => track.scrollBy({ left: -step(), behavior: 'smooth' }));
        root.querySelector('[data-carousel-next]')?.addEventListener('click',
            () => track.scrollBy({ left:  step(), behavior: 'smooth' }));
    });

    /*
     * Circular testimonial carousel.
     * Each card's role is a pure function of (its index - activeIndex) mod N, so
     * there's no "first" or "last" — advancing activeIndex just rotates which
     * testimonial currently owns each slot. Roles map to CSS classes that
     * transform the card into the correct position on stage.
     */
    document.querySelectorAll('[data-testimonials-carousel]').forEach(root => {
        const cards = root.querySelectorAll('.pt-story-card');
        const dots  = root.querySelectorAll('[data-story-dot]');
        const N     = cards.length;
        if (!N) return;

        let activeIndex = 0;

        function roleFor(i) {
            const diff = ((i - activeIndex) % N + N) % N;
            if (diff === 0) return 'front';
            if (diff === 1) return 'peek';
            if (diff === 2) return 'right';
            if (diff === N - 1) return 'left';
            return 'hidden';
        }

        function update() {
            cards.forEach((card, i) => { card.className = 'pt-story-card is-' + roleFor(i); });
            dots.forEach((dot, i) => { dot.classList.toggle('is-active', i === activeIndex); });
        }

        cards.forEach((card, i) => card.addEventListener('click', () => { activeIndex = i; update(); }));
        dots.forEach((dot, i)   => dot.addEventListener('click',  () => { activeIndex = i; update(); }));
        root.querySelector('[data-story-prev]')?.addEventListener('click', () => {
            activeIndex = ((activeIndex - 1) % N + N) % N; update();
        });
        root.querySelector('[data-story-next]')?.addEventListener('click', () => {
            activeIndex = ((activeIndex + 1) % N + N) % N; update();
        });

        update();
    });
</script>
@endpush
