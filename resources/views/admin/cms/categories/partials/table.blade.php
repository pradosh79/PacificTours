<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead><tr>
            <th style="width:2rem"><input type="checkbox" class="form-check-input" @change="toggleAll($event)"></th>
            <th>Name</th><th>Parent</th><th>Slug</th><th class="text-center">Tours</th><th>Menu</th><th>Active</th><th></th>
        </tr></thead>
        <tbody>
        @forelse ($records as $record)
            <tr>
                <td><input type="checkbox" class="form-check-input" value="{{ $record->id }}" x-model.number="selected"></td>
                <td class="fw-semibold">{{ $record->name }}</td>
                <td>{{ $record->parent?->name ?? '—' }}</td>
                <td><code>{{ $record->slug }}</code></td>
                <td class="text-center">{{ $record->tours_count ?? '—' }}</td>
                <td>{!! $record->show_in_menu ? '✓' : '—' !!}</td>
                <td>{!! $record->is_active ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-secondary">Hidden</span>' !!}</td>
                <td class="text-end">
                    <form method="POST" action="{{ route('admin.categories.destroy', $record->id) }}"
                          onsubmit="return confirm('Delete this category? Tours using it keep their data.')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-muted py-5">Nothing here yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="panel-foot">{{ $records->links() }}</div>
