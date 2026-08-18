{{--
    PUBLIC LAYOUT — client-approved Pacific Tours design (2026-08-14)
    ---------------------------------------------------------------------------
    Loads the pre-compiled design stylesheet directly from /public so the site
    renders correctly whether or not `npm run build` has ever been run.
    When Vite IS built, its output layers on top and takes precedence.
--}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    {{-- Compiled design CSS — always present, no build step required. --}}
    @php $cssPath = public_path('css/pacific-tours.css'); @endphp
    @if (file_exists($cssPath))
        <link rel="stylesheet" href="{{ asset('css/pacific-tours.css') }}?v={{ filemtime($cssPath) }}">
    @endif

    @include('web.partials.seo', ['model' => $seoModel ?? null])

    {{-- Vite is optional here: if the manifest exists it layers extra JS/CSS,
         otherwise the plain-link above is enough on its own. --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @endif
    @stack('head')
</head>
<body class="site @if(request()->routeIs('home')) site--home @endif">
    @include('web.partials.header')

    <main id="main">
        @if (session('success'))<div class="container"><div class="alert alert-success mt-3">{{ session('success') }}</div></div>@endif
        @if (session('error'))<div class="container"><div class="alert alert-danger mt-3">{{ session('error') }}</div></div>@endif

        @yield('content')
    </main>

    @include('web.partials.footer')
    @stack('scripts')
</body>
</html>
