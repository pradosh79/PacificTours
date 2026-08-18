@php
    $segments = collect(request()->segments())->filter(fn ($s) => ! is_numeric($s) && ! Str::isUuid($s));
@endphp
<nav aria-label="Breadcrumb">
    <ol class="breadcrumb small mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
        @foreach ($segments->skip(1) as $index => $segment)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">{{ Str::headline($segment) }}</li>
        @endforeach
    </ol>
</nav>
