{{-- Footer for the Vancouver homepage design. --}}
@php
    $companyName    = setting('general.company_name', 'Pacific Tours');
    $companyEmail   = setting('general.company_email', 'pacifictoursvancouver@gmail.com');
    $companyPhone   = setting('general.company_phone', '6043581236');
    $companyAddress = setting('general.company_address', '28 East 19th Avenue, Vancouver BC V5V 1H7 Canada');
    $logoSrc        = setting('general.logo_light')
        ? upload_url(setting('general.logo_light'))
        : asset('images/pacifictours-logo.png');
@endphp
<footer class="pt-footer">
    <div class="container">
        <div class="row g-4 pt-footer__row">
            <div class="col-lg-4">
                <a class="pt-footer__brand" href="{{ route('home') }}">
                    <img src="{{ $logoSrc }}" alt="{{ $companyName }}" class="pt-footer__logo">
                </a>
                <p class="pt-footer__blurb">
                    {{ $companyName }} is a Vancouver-based sightseeing tour operator specialising in professionally
                    operated carrier-directed sightseeing tours throughout British Columbia.
                </p>
                <div class="pt-footer__social">
                    @foreach ([
                        'facebook'  => setting('social.facebook',  'https://facebook.com/pacifictours'),
                        'instagram' => setting('social.instagram', 'https://instagram.com/pacifictours'),
                        'x-twitter' => setting('social.twitter'),
                        'linkedin'  => setting('social.linkedin'),
                        'whatsapp'  => setting('social.whatsapp', 'https://wa.me/16043581236'),
                    ] as $icon => $url)
                        @if ($url)
                            <a href="{{ $url }}" aria-label="{{ $icon }}" target="_blank" rel="noopener">
                                <x-icon :name="$icon" width="16" height="16" />
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h4 class="pt-footer__heading">Useful Links</h4>
                <ul class="pt-footer__list">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('destinations.index') }}">Locations</a></li>
                    <li><a href="{{ route('pages.show', 'about-us') }}">About Us</a></li>
                    <li><a href="{{ route('blog.index') }}">Resources</a></li>
                    <li><a href="{{ url('/contact') }}">Contact us</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h4 class="pt-footer__heading">Policy Links</h4>
                <ul class="pt-footer__list">
                    <li><a href="{{ route('pages.show', 'privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('pages.show', 'terms-conditions') }}">Terms &amp; Service</a></li>
                    <li><a href="{{ route('pages.show', 'security-policy') }}">Security Policy</a></li>
                    <li><a href="{{ route('pages.show', 'cookie-policy') }}">Cookie policy</a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h4 class="pt-footer__heading">Contact Info</h4>
                <ul class="pt-footer__contact">
                    @if ($companyAddress)
                        <li><x-icon name="map-pin" width="14" height="14" /> {{ $companyAddress }}</li>
                    @endif
                    @if ($companyEmail)
                        <li><x-icon name="mail" width="14" height="14" /> <a href="mailto:{{ $companyEmail }}">{{ $companyEmail }}</a></li>
                    @endif
                    @if ($companyPhone)
                        <li><x-icon name="phone" width="14" height="14" /> <a href="tel:{{ preg_replace('/\D/', '', $companyPhone) }}">{{ $companyPhone }}</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <p class="pt-footer__copyright">
            Copyright {{ date('Y') }} {{ $companyName }}. All Rights Reserved.
        </p>
    </div>
</footer>
