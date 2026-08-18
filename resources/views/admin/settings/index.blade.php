@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<div class="row g-3">
    <div class="col-lg-3">
        <nav class="list-group">
            @foreach (['general' => 'General', 'home' => 'Home page content', 'theme' => 'Appearance & currency', 'payment' => 'Payments', 'mail' => 'Email', 'social' => 'Social links', 'seo' => 'SEO'] as $key => $label)
                <a class="list-group-item list-group-item-action {{ $group === $key ? 'active' : '' }}"
                   href="{{ route('admin.settings.edit', $key) }}">{{ $label }}</a>
            @endforeach
        </nav>
    </div>

    <div class="col-lg-9">
        <form class="panel" method="POST" action="{{ route('admin.settings.update', $group) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <header class="panel-head"><h2 class="h6 mb-0">{{ Str::headline($group) }}</h2></header>

            <div class="panel-body row g-3">
                @switch($group)
                    @case('general')
                        <div class="col-md-6"><label class="form-label small">Company name</label><input name="company_name" class="form-control" value="{{ setting('general.company_name') }}"></div>
                        <div class="col-md-6"><label class="form-label small">Company email</label><input type="email" name="company_email" class="form-control" value="{{ setting('general.company_email') }}"></div>
                        <div class="col-md-6"><label class="form-label small">Phone</label><input name="company_phone" class="form-control" value="{{ setting('general.company_phone') }}"></div>
                        <div class="col-md-6"><label class="form-label small">Address</label><input name="company_address" class="form-control" value="{{ setting('general.company_address') }}"></div>
                        <div class="col-md-4"><label class="form-label small">Logo</label><input type="file" name="logo" accept="image/*" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label small">Favicon</label><input type="file" name="favicon" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label small">Invoice due (days)</label><input type="number" name="invoice_due_days" class="form-control" value="{{ setting('general.invoice_due_days', 7) }}"></div>
                        <div class="col-md-4">
                            <label class="form-label small">Unpaid booking TTL (hours)</label>
                            <input type="number" name="unpaid_booking_ttl_hours" class="form-control" value="{{ setting('general.unpaid_booking_ttl_hours', 48) }}">
                            <p class="form-text small">After this, unpaid bookings cancel and their seats return to inventory.</p>
                        </div>
                        @break

                    @case('theme')
                        <div class="col-md-4">
                            <label class="form-label small">Default currency</label>
                            <select name="currency" class="form-select">
                                @foreach (\App\Models\Currency::all() as $currency)
                                    <option value="{{ $currency->code }}" @selected(setting('theme.currency') === $currency->code)>{{ $currency->code }} — {{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Default language</label>
                            <select name="language" class="form-select">
                                @foreach (\App\Models\Language::all() as $language)
                                    <option value="{{ $language->code }}" @selected(setting('theme.language') === $language->code)>{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4"><label class="form-label small">Timezone</label><input name="timezone" class="form-control" value="{{ setting('theme.timezone', 'America/Vancouver') }}"></div>
                        @break

                    @case('payment')
                        <div class="col-12">
                            <p class="small text-muted">
                                API keys live in <code>.env</code>. These switches control whether a gateway is
                                offered at checkout, so you can disable one without a deploy.
                            </p>
                        </div>
                        @foreach (['stripe' => 'Stripe (cards)', 'paypal' => 'PayPal', 'manual' => 'Bank transfer / office payment'] as $key => $label)
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="{{ $key }}_enabled" value="1"
                                           id="gw-{{ $key }}" @checked(setting("payment.{$key}_enabled"))>
                                    <label class="form-check-label small" for="gw-{{ $key }}">{{ $label }}</label>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <label class="form-label small">Bank transfer instructions</label>
                            <textarea name="manual_instructions" rows="4" class="form-control">{{ setting('payment.manual_instructions') }}</textarea>
                        </div>
                        @break

                    @case('mail')
                        <div class="col-md-6"><label class="form-label small">From name</label><input name="from_name" class="form-control" value="{{ setting('mail.from_name') }}"></div>
                        <div class="col-md-6"><label class="form-label small">From address</label><input type="email" name="from_address" class="form-control" value="{{ setting('mail.from_address') }}"></div>
                        <div class="col-md-6"><label class="form-label small">Admin alert address</label><input type="email" name="admin_address" class="form-control" value="{{ setting('mail.admin_address') }}"></div>
                        <div class="col-md-6"><label class="form-label small">Email footer</label><input name="footer_text" class="form-control" value="{{ setting('mail.footer_text') }}"></div>
                        @break

                    @case('social')
                        @foreach (['facebook', 'instagram', 'twitter', 'youtube', 'tripadvisor', 'linkedin'] as $network)
                            <div class="col-md-6">
                                <label class="form-label small">{{ ucfirst($network) }}</label>
                                <input name="{{ $network }}" class="form-control" value="{{ setting("social.{$network}") }}" placeholder="https://">
                            </div>
                        @endforeach
                        @break

                    @case('seo')
                        <div class="col-12"><label class="form-label small">Default meta title</label><input name="meta_title" class="form-control" value="{{ setting('seo.meta_title') }}"></div>
                        <div class="col-12"><label class="form-label small">Default meta description</label><textarea name="meta_description" rows="3" class="form-control">{{ setting('seo.meta_description') }}</textarea></div>
                        <div class="col-md-6"><label class="form-label small">Google Analytics ID</label><input name="google_analytics_id" class="form-control" value="{{ setting('seo.google_analytics_id') }}"></div>
                        <div class="col-md-6"><label class="form-label small">Search Console verification</label><input name="search_console" class="form-control" value="{{ setting('seo.search_console') }}"></div>
                        @break

                    @case('home')
                        {{-- HERO --}}
                        <div class="col-12"><h3 class="h6 text-uppercase text-muted small mt-1 mb-2">Hero</h3></div>
                        <div class="col-md-4">
                            <label class="form-label small">Title — lead</label>
                            <input name="hero_title_lead" class="form-control" value="{{ setting('home.hero_title_lead') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Title — accent (orange)</label>
                            <input name="hero_title_accent" class="form-control" value="{{ setting('home.hero_title_accent') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Title — trail</label>
                            <input name="hero_title_trail" class="form-control" value="{{ setting('home.hero_title_trail') }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small">Subtitle</label>
                            <textarea name="hero_subtitle" rows="2" class="form-control">{{ setting('home.hero_subtitle') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">CTA label</label>
                            <input name="hero_cta_label" class="form-control" value="{{ setting('home.hero_cta_label') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Hero background image</label>
                            <input type="file" name="hero_bg" accept="image/*" class="form-control">
                            @if ($bg = setting('home.hero_bg'))
                                <p class="form-text small">Current: <a href="{{ upload_url($bg) }}" target="_blank">view</a></p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Section title (below quote band)</label>
                            <input name="section_title" class="form-control" value="{{ setting('home.section_title') }}">
                        </div>

                        {{-- DESTINATIONS --}}
                        <div class="col-12"><h3 class="h6 text-uppercase text-muted small mt-3 mb-2">Popular Destinations block</h3></div>
                        <div class="col-md-6">
                            <label class="form-label small">Heading</label>
                            <input name="destinations_heading" class="form-control" value="{{ setting('home.destinations_heading') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Sprinter van image</label>
                            <input type="file" name="sprinter_image" accept="image/*" class="form-control">
                            @if ($img = setting('home.sprinter_image'))
                                <p class="form-text small">Current: <a href="{{ upload_url($img) }}" target="_blank">view</a></p>
                            @endif
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Intro paragraph</label>
                            <textarea name="destinations_intro" rows="3" class="form-control">{{ setting('home.destinations_intro') }}</textarea>
                            <p class="form-text small">Pick which destinations appear here by marking them "Featured" in Admin → Destinations.</p>
                        </div>

                        {{-- FEATURED TOURS --}}
                        <div class="col-12"><h3 class="h6 text-uppercase text-muted small mt-3 mb-2">Featured Tour Packages block</h3></div>
                        <div class="col-md-6">
                            <label class="form-label small">Heading</label>
                            <input name="featured_heading" class="form-control" value="{{ setting('home.featured_heading') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Intro paragraph</label>
                            <textarea name="featured_intro" rows="2" class="form-control">{{ setting('home.featured_intro') }}</textarea>
                            <p class="form-text small">Which tours appear here is controlled by the "Featured" toggle on each tour.</p>
                        </div>

                        {{-- WHY --}}
                        <div class="col-12"><h3 class="h6 text-uppercase text-muted small mt-3 mb-2">Why Pacific Tours block</h3></div>
                        <div class="col-md-6">
                            <label class="form-label small">Heading</label>
                            <input name="why_heading" class="form-control" value="{{ setting('home.why_heading') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Intro paragraph</label>
                            <textarea name="why_intro" rows="2" class="form-control">{{ setting('home.why_intro') }}</textarea>
                        </div>
                        <div class="col-12">
                            <p class="form-text small">Feature tiles themselves are managed in
                                <a href="{{ route('admin.home-features.index') }}">Home page features</a>.
                            </p>
                        </div>

                        {{-- TESTIMONIALS --}}
                        <div class="col-12"><h3 class="h6 text-uppercase text-muted small mt-3 mb-2">Testimonials block</h3></div>
                        <div class="col-md-6">
                            <label class="form-label small">Heading</label>
                            <input name="testimonials_heading" class="form-control" value="{{ setting('home.testimonials_heading') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Intro paragraph</label>
                            <textarea name="testimonials_intro" rows="2" class="form-control">{{ setting('home.testimonials_intro') }}</textarea>
                        </div>

                        {{-- FLEET --}}
                        <div class="col-12"><h3 class="h6 text-uppercase text-muted small mt-3 mb-2">Sprinter feature band</h3></div>
                        <div class="col-12">
                            <label class="form-label small">Heading</label>
                            <input name="fleet_heading" class="form-control" value="{{ setting('home.fleet_heading') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Background image</label>
                            <input type="file" name="fleet_bg" accept="image/*" class="form-control">
                            @if ($bg = setting('home.fleet_bg'))
                                <p class="form-text small">Current: <a href="{{ upload_url($bg) }}" target="_blank">view</a></p>
                            @endif
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Feature bullets</label>
                            @php $features = (array) setting('home.fleet_features', []); @endphp
                            <div class="row g-2">
                                @for ($i = 0; $i < 12; $i++)
                                    <div class="col-md-4 col-lg-3">
                                        <input name="fleet_features[]" class="form-control form-control-sm"
                                               value="{{ $features[$i] ?? '' }}" placeholder="e.g. Air Conditioning">
                                    </div>
                                @endfor
                            </div>
                            <p class="form-text small">Empty fields are ignored on save.</p>
                        </div>

                        {{-- CONTACT --}}
                        <div class="col-12"><h3 class="h6 text-uppercase text-muted small mt-3 mb-2">Contact block</h3></div>
                        <div class="col-md-4">
                            <label class="form-label small">Heading</label>
                            <input name="contact_heading" class="form-control" value="{{ setting('home.contact_heading') }}">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small">Intro paragraph</label>
                            <textarea name="contact_intro" rows="2" class="form-control">{{ setting('home.contact_intro') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Google Maps embed URL</label>
                            <input name="map_embed_url" class="form-control" value="{{ setting('home.map_embed_url') }}"
                                   placeholder="https://www.google.com/maps/embed?pb=…">
                            <p class="form-text small">Google Maps → Share → Embed a map → copy the <code>src</code> URL.</p>
                        </div>
                        @break
                @endswitch
            </div>

            <div class="panel-foot">
                @can('manage-settings')
                    <button class="btn btn-primary btn-sm">Save settings</button>
                @else
                    <p class="small text-muted mb-0">You have read-only access to settings.</p>
                @endcan
            </div>
        </form>
    </div>
</div>
@endsection
