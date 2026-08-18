{{--
    Tour card.

    IMPORTANT: `position-relative` on the article is load-bearing. Bootstrap's
    `.stretched-link` puts an absolutely-positioned ::after over its nearest
    positioned ancestor. Without position-relative here, that overlay escapes
    the card and covers the whole viewport — every click on the page (filter
    dropdowns, sort menu, empty space) navigates to the last card's URL.
--}}
<article class="border rounded overflow-hidden h-100 d-flex flex-column position-relative">
    <img src="{{ upload_url($tour->thumbnail) }}" alt="{{ $tour->title }}"
         class="w-100" style="height:170px;object-fit:cover" loading="lazy">

    <div class="p-3 d-flex flex-column flex-grow-1">
        <p class="small text-muted mb-1">
            {{ $tour->destination?->name }} · {{ $tour->duration_days }}D/{{ $tour->duration_nights }}N
        </p>
        <h3 class="h6 mb-1">
            <a class="stretched-link text-decoration-none text-dark"
               href="{{ route('tours.show', $tour->slug) }}">{{ $tour->title }}</a>
        </h3>
        <p class="small text-muted flex-grow-1">{{ Str::limit($tour->summary, 80) }}</p>
        <p class="mb-0">
            @if ($tour->hasDiscount())<s class="text-muted small">{{ money($tour->base_price) }}</s>@endif
            <strong>{{ money($tour->sale_price) }}</strong>
            <span class="small text-muted">· {{ number_format((float) $tour->average_rating, 1) }}★ ({{ $tour->reviews_count }})</span>
        </p>
    </div>
</article>
