<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
        <tr>
            <th style="width:2rem"><input type="checkbox" class="form-check-input" @change="toggleAll($event)"></th>
            <th>Tour</th><th>Category</th><th>Duration</th><th class="text-end">Price</th>
            <th class="text-center">Bookings</th><th>Status</th><th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($tours as $tour)
            <tr>
                <td><input type="checkbox" class="form-check-input" value="{{ $tour->id }}" x-model.number="selected"></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ upload_url($tour->thumbnail) }}" alt="" width="44" height="44" class="rounded object-fit-cover">
                        <div>
                            <a href="{{ route('admin.tours.edit', $tour->uuid) }}" class="fw-semibold">{{ $tour->title }}</a>
                            <span class="d-block small text-muted">{{ $tour->code }} · {{ $tour->destination?->name }}</span>
                        </div>
                    </div>
                </td>
                <td>{{ $tour->category?->name }}</td>
                <td>{{ $tour->duration_days }}D / {{ $tour->duration_nights }}N</td>
                <td class="text-end">
                    @if ($tour->hasDiscount())
                        <span class="text-decoration-line-through text-muted small">{{ money($tour->base_price) }}</span>
                    @endif
                    {{ money($tour->sale_price) }}
                </td>
                <td class="text-center">{{ $tour->bookings_count }}</td>
                <td><span class="badge text-bg-{{ $tour->status->badge() }}">{{ Str::headline($tour->status->value) }}</span></td>
                <td class="text-end">
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-outline-secondary" href="{{ route('tours.show', $tour->slug) }}" target="_blank">View</a>
                        <a class="btn btn-outline-secondary" href="{{ route('admin.tours.edit', $tour->uuid) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.tours.duplicate', $tour->uuid) }}">@csrf
                            <button class="btn btn-outline-secondary">Duplicate</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-muted py-5">
                No tours match this filter. <a href="{{ route('admin.tours.create') }}">Add the first one</a>.
            </td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="panel-foot">{{ $tours->links() }}</div>
