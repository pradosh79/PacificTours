@php
    $seo = $model?->seo;
    $title = $seo?->meta_title ?? ($title ?? null) ?? setting('seo.meta_title', config('travel.seo.default_title'));
    $description = $seo?->meta_description ?? setting('seo.meta_description', config('travel.seo.default_description'));
    $image = $seo?->og_image ? upload_url($seo->og_image) : asset(config('travel.seo.og_image'));
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $seo?->robots ?? 'index,follow' }}">
<link rel="canonical" href="{{ $seo?->canonical_url ?? url()->current() }}">

<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seo?->og_title ?? $title }}">
<meta property="og:description" content="{{ $seo?->og_description ?? $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:url" content="{{ url()->current() }}">

<meta name="twitter:card" content="{{ $seo?->twitter_card ?? 'summary_large_image' }}">
<meta name="twitter:site" content="{{ config('travel.seo.twitter_handle') }}">

@if ($seo?->schema_markup)
    <script type="application/ld+json">@json($seo->schema_markup)</script>
@endif
