<div class="row g-3 mb-3">
    @foreach ($cards as $label => $value)
        <div class="col-6 col-lg-3">
            <article class="stat-card">
                <p class="stat-value">{{ $value }}</p>
                <p class="stat-label">{{ Str::headline($label) }}</p>
            </article>
        </div>
    @endforeach
</div>
