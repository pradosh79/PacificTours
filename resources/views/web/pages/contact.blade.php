@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <h1 class="h3">Talk to a trip planner</h1>
            <p class="text-muted">We reply within one business day, Pacific time.</p>

            <form method="POST" action="{{ route('contact.submit') }}" class="row g-3 mt-2">
                @csrf
                {{-- honeypot: real people never fill this in --}}
                <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off">

                <div class="col-md-6"><label class="form-label small">Name</label><input name="name" class="form-control" value="{{ old('name', auth()->user()?->full_name) }}" required></div>
                <div class="col-md-6"><label class="form-label small">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()?->email) }}" required></div>
                <div class="col-md-6"><label class="form-label small">Phone</label><input name="phone" class="form-control" value="{{ old('phone') }}"></div>
                <div class="col-md-6"><label class="form-label small">Subject</label><input name="subject" class="form-control" value="{{ old('subject') }}" required></div>
                <div class="col-12"><label class="form-label small">Message</label><textarea name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea></div>
                <div class="col-12"><button class="btn btn-primary">Send message</button></div>
            </form>
        </div>

        <aside class="col-lg-5">
            <div class="border rounded p-4">
                <h2 class="h6">{{ setting('general.company_name') }}</h2>
                <p class="small mb-1">{{ setting('general.company_address') }}</p>
                <p class="small mb-1"><a href="mailto:{{ setting('general.company_email') }}">{{ setting('general.company_email') }}</a></p>
                <p class="small">{{ setting('general.company_phone') }}</p>
                <hr>
                <p class="small text-muted mb-0">
                    Already booked? Quote your booking reference and we'll pull it up straight away.
                </p>
            </div>

            @php
                // Same office location used on the homepage contact block —
                // set/updated at Admin → Settings → Home → Contact block.
                $mapEmbed = setting('home.map_embed_url',
                    'https://maps.google.com/maps?q=28+East+19th+Avenue+Vancouver+BC&t=&z=15&ie=UTF8&iwloc=&output=embed');
            @endphp
            @if ($mapEmbed)
                <div class="border rounded overflow-hidden mt-3">
                    <iframe src="{{ $mapEmbed }}" loading="lazy" allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            title="{{ setting('general.company_name') }} office location"
                            style="width:100%;height:280px;border:0;display:block"></iframe>
                </div>
            @endif
        </aside>
    </div>
</div>
@endsection
