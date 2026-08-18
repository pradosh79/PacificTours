{{-- PLACEHOLDER customer shell --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <aside class="col-lg-3">
            <nav class="list-group list-group-flush border rounded">
                @foreach ([
                    'customer.dashboard'       => 'Overview',
                    'customer.bookings.index'  => 'My bookings',
                    'customer.invoices.index'  => 'Invoices',
                    'customer.wishlist.index'  => 'Saved tours',
                    'customer.tickets.index'   => 'Support',
                    'customer.profile.edit'    => 'Profile & password',
                ] as $route => $label)
                    <a class="list-group-item list-group-item-action {{ request()->routeIs(Str::before($route, '.index').'*') ? 'active' : '' }}"
                       href="{{ route($route) }}">{{ $label }}</a>
                @endforeach
            </nav>
        </aside>
        <div class="col-lg-9">
            <h1 class="h4 mb-3">@yield('heading')</h1>
            @yield('panel')
        </div>
    </div>
</div>
@endsection
