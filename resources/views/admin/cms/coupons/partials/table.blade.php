<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead><tr>
            <th style="width:2rem"><input type="checkbox" class="form-check-input" @change="toggleAll($event)"></th>
            <th>Code</th><th>Discount</th><th>Min spend</th><th class="text-center">Used</th><th>Window</th><th>Status</th><th></th>
        </tr></thead>
        <tbody>
        @forelse ($records as $record)
            @php $expired = $record->expires_at && $record->expires_at->isPast(); @endphp
            <tr class="{{ $expired ? 'opacity-50' : '' }}">
                <td><input type="checkbox" class="form-check-input" value="{{ $record->id }}" x-model.number="selected"></td>
                <td><code class="fw-semibold">{{ $record->code }}</code><span class="d-block small text-muted">{{ $record->name }}</span></td>
                <td>{{ $record->type === 'percentage' ? $record->value.'%' : money($record->value) }}
                    @if ($record->max_discount)<span class="small text-muted d-block">max {{ money($record->max_discount) }}</span>@endif
                </td>
                <td>{{ $record->min_spend > 0 ? money($record->min_spend) : '—' }}</td>
                <td class="text-center">{{ $record->used_count }}{{ $record->usage_limit ? ' / '.$record->usage_limit : '' }}</td>
                <td class="small">
                    {{ $record->starts_at?->format('d M Y') ?? 'any time' }} →
                    {{ $record->expires_at?->format('d M Y') ?? 'no end' }}
                </td>
                <td>
                    @if ($expired)<span class="badge text-bg-secondary">Expired</span>
                    @elseif ($record->is_active)<span class="badge text-bg-success">Active</span>
                    @else<span class="badge text-bg-secondary">Off</span>@endif
                </td>
                <td class="text-end">
                    <form method="POST" action="{{ route('admin.coupons.destroy', $record->id) }}" onsubmit="return confirm('Delete this coupon?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-muted py-5">No coupons yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="panel-foot">{{ $records->links() }}</div>
