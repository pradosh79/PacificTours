<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead><tr>
            <th style="width:2rem"><input type="checkbox" class="form-check-input" @change="toggleAll($event)"></th>
            <th>Destination</th><th>Country</th><th class="text-center">Tours</th><th>Featured</th><th>Active</th><th></th>
        </tr></thead>
        <tbody>
        @forelse ($records as $record)
            <tr>
                <td><input type="checkbox" class="form-check-input" value="{{ $record->id }}" x-model.number="selected"></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ upload_url($record->thumbnail) }}" alt="" width="40" height="40" class="rounded object-fit-cover">
                        <div>
                            <span class="fw-semibold d-block">{{ $record->name }}</span>
                            <code class="small">{{ $record->slug }}</code>
                        </div>
                    </div>
                </td>
                <td>{{ $record->country?->name }}</td>
                <td class="text-center">{{ $record->tours_count ?? '—' }}</td>
                <td>{!! $record->is_featured ? '★' : '—' !!}</td>
                <td>{!! $record->is_active ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-secondary">Hidden</span>' !!}</td>
                <td class="text-end">
                    <div class="d-inline-flex gap-1">
                        @php
                            $payload = [
                                'id'                 => $record->id,
                                'name'               => $record->name,
                                'country_id'         => $record->country_id,
                                'best_time_to_visit' => $record->best_time_to_visit,
                                'short_description'  => $record->short_description,
                                'is_featured'        => (bool) $record->is_featured,
                                'is_active'          => (bool) $record->is_active,
                                'thumbnail_url'      => $record->thumbnail ? upload_url($record->thumbnail) : null,
                                'banner_url'         => $record->banner ? upload_url($record->banner) : null,
                            ];
                        @endphp
                        <button type="button" class="btn btn-sm btn-outline-secondary" @click='openEdit(@json($payload))'>
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.destinations.destroy', $record->id) }}" onsubmit="return confirm('Delete this destination?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-5">Nothing here yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="panel-foot">{{ $records->links() }}</div>
