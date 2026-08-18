{{-- PLACEHOLDER auth shell — replaced by Figma --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · {{ setting('general.company_name', 'Pacific Tours') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh">
    <div style="width:100%;max-width:420px">
        <a class="d-block text-center mb-4" href="{{ route('home') }}">
            <img class="auth-logo" src="{{ asset('images/pacifictours-logo.png') }}" alt="{{ setting('general.company_name', 'Pacific Tours') }}">
        </a>

        <div class="card">
            <div class="card-body p-4">
                <h1 class="h5 mb-3">@yield('title')</h1>

                @if (session('success'))<div class="alert alert-success small">{{ session('success') }}</div>@endif
                @if (session('error'))<div class="alert alert-danger small">{{ session('error') }}</div>@endif
                @if ($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                @yield('form')
            </div>
        </div>

        <p class="text-center small mt-3">@yield('footer-link')</p>
    </div>
</div>
</body>
</html>
