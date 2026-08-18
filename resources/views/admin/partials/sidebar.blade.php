{{-- Permission-aware navigation: a link only renders when the signed-in role
     can actually reach the screen behind it. --}}
@php
    $nav = [
        ['label' => 'Dashboard',   'route' => 'admin.dashboard',        'icon' => 'grid',    'can' => null],
        ['heading' => 'Operations'],
        ['label' => 'Bookings',    'route' => 'admin.bookings.index',   'icon' => 'ticket',  'can' => 'booking.view',
         'badge' => \App\Models\Booking::pending()->count()],
        ['label' => 'Payments',    'route' => 'admin.payments.index',   'icon' => 'card',    'can' => 'payment.view'],
        ['label' => 'Customers',   'route' => 'admin.users.index',      'icon' => 'users',   'can' => 'customer.view'],
        ['heading' => 'Catalogue'],
        ['label' => 'Tours',       'route' => 'admin.tours.index',      'icon' => 'compass', 'can' => 'tour.view'],
        ['label' => 'Categories',  'route' => 'admin.categories.index', 'icon' => 'tag',     'can' => 'category.view'],
        ['label' => 'Destinations','route' => 'admin.destinations.index','icon' => 'pin',    'can' => 'destination.view'],
        ['label' => 'Coupons',     'route' => 'admin.coupons.index',    'icon' => 'percent', 'can' => 'coupon.view'],
        ['label' => 'Reviews',     'route' => 'admin.reviews.index',    'icon' => 'star',    'can' => 'review.view'],
        ['heading' => 'Content'],
        ['label' => 'Pages',           'route' => 'admin.pages.index',           'icon' => 'file',    'can' => 'cms.view'],
        ['label' => 'Home features',   'route' => 'admin.home-features.index',   'icon' => 'grid',    'can' => 'cms.view'],
        ['label' => 'Testimonials',    'route' => 'admin.testimonials.index',    'icon' => 'star',    'can' => 'cms.view'],
        ['label' => 'Banners',         'route' => 'admin.banners.index',         'icon' => 'tag',     'can' => 'cms.view'],
        ['label' => 'FAQs',            'route' => 'admin.faqs.index',            'icon' => 'ticket',  'can' => 'cms.view'],
        ['heading' => 'Insight'],
        ['label' => 'Reports',     'route' => 'admin.reports.show',     'params' => ['type' => 'revenue'], 'icon' => 'chart', 'can' => 'report.view'],
        ['label' => 'Settings',    'route' => 'admin.settings.edit',    'icon' => 'gear',    'can' => 'setting.view'],
    ];
@endphp

<aside class="admin-sidebar" x-data="{ open: false }" :class="{ 'is-open': open }">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <span class="sidebar-brand-logo">
            <img src="{{ asset('images/pacifictours-logo.png') }}" alt="{{ setting('general.company_name', 'Pacific Tours') }}">
        </span>
    </a>

    <nav class="sidebar-nav">
        @foreach ($nav as $item)
            @if (isset($item['heading']))
                <p class="sidebar-heading">{{ $item['heading'] }}</p>
            @elseif (! $item['can'] || auth()->user()->can($item['can']) || auth()->user()->isSuperAdmin())
                @php $url = route($item['route'], $item['params'] ?? []); @endphp
                <a href="{{ $url }}" class="sidebar-link {{ request()->routeIs($item['route']) ? 'is-active' : '' }}">
                    <x-icon :name="$item['icon']" />
                    <span>{{ $item['label'] }}</span>
                    @if (! empty($item['badge']))
                        <span class="badge text-bg-warning ms-auto">{{ $item['badge'] }}</span>
                    @endif
                </a>
            @endif
        @endforeach
    </nav>

    <div class="sidebar-footer">
        <p class="small mb-1">{{ auth()->user()->full_name }}</p>
        <p class="small text-muted mb-2">{{ auth()->user()->getRoleNames()->map(fn ($r) => Str::headline($r))->join(', ') }}</p>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button class="btn btn-sm btn-outline-light w-100">Sign out</button>
        </form>
    </div>
</aside>
