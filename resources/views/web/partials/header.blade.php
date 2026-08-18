{{-- Header for the Vancouver homepage design. --}}
@php
    // Use the packaged logo file when the admin hasn't uploaded a custom one.
    $logoSrc = setting('general.logo')
        ? upload_url(setting('general.logo'))
        : asset('images/pacifictours-logo-black.png');
@endphp
<header class="pt-header">
    <div class="container pt-header__inner">
        <a class="pt-header__brand" href="{{ route('home') }}">
            <img src="{{ $logoSrc }}" alt="{{ setting('general.company_name', 'Pacific Tours') }}">
        </a>

        <nav class="pt-header__nav d-none d-lg-flex" aria-label="Primary">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
            <a href="{{ route('destinations.index') }}" class="{{ request()->routeIs('destinations.*') ? 'is-active' : '' }}">Locations</a>
            <a href="{{ route('pages.show', 'about-us') }}">About Us</a>
            <a href="{{ route('blog.index') }}">Resources</a>
            <a href="{{ url('/contact') }}">Contact Us</a>
        </nav>

        {{--
            Icons match the mockup: search, wishlist, user. All three always
            visible; clicking user goes to sign-in when logged out, dashboard
            when logged in. Wishlist requires auth so it redirects gracefully.
        --}}
        <div class="pt-header__actions">
            <a href="{{ route('tours.index') }}" class="pt-header__icon" aria-label="Search tours" title="Search">
                <x-icon name="search" width="18" height="18" />
            </a>
            <a href="{{ auth()->check() ? route('customer.wishlist.index') : route('login') }}"
               class="pt-header__icon" aria-label="Saved tours" title="Saved tours">
                <x-icon name="heart" width="18" height="18" />
            </a>
            <a href="{{ auth()->check() ? route('customer.dashboard') : route('login') }}"
               class="pt-header__icon" aria-label="{{ auth()->check() ? 'My account' : 'Sign in' }}"
               title="{{ auth()->check() ? 'My account' : 'Sign in' }}">
                <x-icon name="user" width="18" height="18" />
            </a>
            <a href="{{ route('tours.index') }}" class="btn-pill btn-pill--primary pt-header__cta">Book A Tour</a>
        </div>
    </div>
</header>
