@php
    $fileFields = $fileFields ?? [];
@endphp
<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead>
        <tr>
            <th style="width:2rem"><input type="checkbox" class="form-check-input" @change="toggleAll($event)"></th>
            @foreach ($columns as $label)<th>{{ $label }}</th>@endforeach
            <th>Status</th>
            <th class="text-end">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($records as $record)
            <tr>
                <td><input type="checkbox" class="form-check-input" value="{{ $record->id }}" x-model.number="selected"></td>
                @foreach (array_keys($columns) as $field)
                    <td>
                        @php $value = data_get($record, $field); @endphp
                        @if (in_array($field, $fileFields, true) && $value)
                            {{-- File columns get a thumbnail rather than a raw path. --}}
                            <img src="{{ asset('storage/'.$value) }}" alt=""
                                 style="height:36px;width:36px;object-fit:cover" class="rounded border">
                        @else
                            {{ $value !== null && $value !== '' ? $value : '—' }}
                        @endif
                    </td>
                @endforeach
                <td>
                    @if (isset($record->is_active))
                        {!! $record->is_active
                            ? '<span class="badge text-bg-success">Active</span>'
                            : '<span class="badge text-bg-secondary">Hidden</span>' !!}
                    @else
                        —
                    @endif
                </td>
                <td class="text-end">
                    <div class="d-inline-flex gap-1">
                        @php
                            /* Serialise the row for the edit modal — only scalar/editable columns. */
                            $editable = collect($columns)
                                ->reject(fn ($l, $f) => str_contains($f, '.'))
                                ->keys()->push('id')->push('is_active');
                            $payload = collect($record->getAttributes())
                                ->only($editable->all())
                                ->map(fn ($v, $k) => $k === 'is_active' ? (bool) $v : $v);
                        @endphp
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                @click='openEdit(@json($payload))'>
                            Edit
                        </button>
                        <form method="POST" action="{{ route($routeName.'.destroy', $record->id) }}"
                              onsubmit="return confirm('Delete this record?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="{{ count($columns) + 3 }}" class="text-center text-muted py-5">Nothing here yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="panel-foot">{{ $records->links() }}</div>
