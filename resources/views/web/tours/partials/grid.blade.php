<div class="row g-3">
    @forelse ($tours as $tour)
        <div class="col-md-6 col-xl-4">@include('web.tours.partials.card', ['tour' => $tour])</div>
    @empty
        <div class="col-12">
            <p class="text-muted py-5 text-center">
                No tours match those filters. <a href="{{ route('tours.index') }}">Clear them</a> and start again.
            </p>
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $tours->withQueryString()->links() }}</div>
