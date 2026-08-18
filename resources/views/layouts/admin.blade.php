{{-- Admin shell. Bootstrap 5 + Alpine; no build-time coupling to the public
     theme, so the Figma rebuild of the storefront leaves this untouched. --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · {{ setting('general.company_name', 'Pacific Tours') }}</title>
    <link rel="icon" href="{{ upload_url(setting('general.favicon'), 'favicon.ico') }}">
    @vite(['resources/sass/admin.scss', 'resources/js/admin.js'])
</head>
<body class="admin">
<div class="admin-shell">
    @include('admin.partials.sidebar')

    <div class="admin-main">
        @include('admin.partials.topbar')

        <main class="admin-content" id="admin-content">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h1 class="h4 mb-1">@yield('title')</h1>
                    @include('admin.partials.breadcrumb')
                </div>
                <div class="d-flex gap-2">@yield('actions')</div>
            </div>

            @include('admin.partials.alerts')

            @yield('content')
        </main>
    </div>
</div>

@stack('modals')
@stack('scripts')
</body>
</html>
