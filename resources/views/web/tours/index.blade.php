@extends('layouts.app')

{{-- PLACEHOLDER — variables: tours (paginator), facets, query --}}

@section('content')
<div class="container py-4" x-data="{ filters: @js($query) }">
    <h1 class="h4 mb-3">Tours{{ request('keyword') ? ' matching "'.request('keyword').'"' : '' }}</h1>

    <div class="row g-4">
        <aside class="col-lg-3">
            {{--
                Filter form — GET-submits back to /tours with a whitelisted set
                of query params. Names MUST match SearchService::normalise() and
                Tour::filterXxx() methods: min_price / max_price / min_duration
                / max_duration (NOT the price_min/duration_min form that was
                here before — those got silently stripped by the whitelist).
            --}}
            <form id="filters" method="GET" class="border rounded p-3">
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Category</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="category"
                               value="" id="cat-all" @checked(! request('category'))>
                        <label class="form-check-label small" for="cat-all">All categories</label>
                    </div>
                    @foreach ($facets['categories'] ?? [] as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category"
                                   id="cat-{{ $category['slug'] }}"
                                   value="{{ $category['slug'] }}" @checked(request('category') === $category['slug'])>
                            <label class="form-check-label small" for="cat-{{ $category['slug'] }}">
                                {{ $category['name'] }}
                                @isset($category['tours_count']) ({{ $category['tours_count'] }}) @endisset
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Destination</label>
                    <select name="destination" class="form-select form-select-sm">
                        <option value="">Anywhere</option>
                        @foreach ($facets['destinations'] ?? [] as $destination)
                            <option value="{{ $destination['slug'] }}" @selected(request('destination') === $destination['slug'])>
                                {{ $destination['name'] }}
                                @isset($destination['tours_count']) ({{ $destination['tours_count'] }}) @endisset
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6"><label class="form-label small">Min $</label><input type="number" name="min_price" min="0" value="{{ request('min_price') }}" class="form-control form-control-sm"></div>
                    <div class="col-6"><label class="form-label small">Max $</label><input type="number" name="max_price" min="0" value="{{ request('max_price') }}" class="form-control form-control-sm"></div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6"><label class="form-label small">Min days</label><input type="number" name="min_duration" min="1" value="{{ request('min_duration') }}" class="form-control form-control-sm"></div>
                    <div class="col-6"><label class="form-label small">Max days</label><input type="number" name="max_duration" min="1" value="{{ request('max_duration') }}" class="form-control form-control-sm"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Travelling on</label>
                    <input type="date" name="travel_date" value="{{ request('travel_date') }}" class="form-control form-control-sm" min="{{ now()->toDateString() }}">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="available_only" value="1" id="avail" @checked(request('available_only'))>
                    <label class="form-check-label small" for="avail">Only show available departures</label>
                </div>

                <button type="submit" class="btn btn-primary btn-sm w-100">Apply filters</button>
                <a class="btn btn-link btn-sm w-100" href="{{ route('tours.index') }}">Clear</a>
            </form>
        </aside>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="small text-muted mb-0">{{ $tours->total() }} tours</p>
                <select class="form-select form-select-sm w-auto" onchange="location = this.value">
                    @foreach (['popular' => 'Most popular', 'price_asc' => 'Price: low to high', 'price_desc' => 'Price: high to low', 'rating' => 'Highest rated', 'newest' => 'Newest'] as $value => $label)
                        <option value="{{ request()->fullUrlWithQuery(['sort' => $value]) }}" @selected(request('sort') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div id="tour-grid">@include('web.tours.partials.grid', ['tours' => $tours])</div>
        </div>
    </div>
</div>
@endsection
