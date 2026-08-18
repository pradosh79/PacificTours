@extends('layouts.admin')
@section('title', 'Flash sales')
@section('actions')<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add">New flash sale</button>@endsection

@section('content')
<div class="panel">
    <table class="table align-middle mb-0">
        <thead><tr><th>Name</th><th>Discount</th><th>Window</th><th class="text-center">Tours</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse ($sales as $sale)
            <tr>
                <td class="fw-semibold">{{ $sale->name }}</td>
                <td>{{ $sale->discount_type === 'percentage' ? $sale->discount_value.'%' : money($sale->discount_value) }}</td>
                <td class="small">{{ $sale->starts_at->format('d M Y H:i') }} → {{ $sale->ends_at->format('d M Y H:i') }}</td>
                <td class="text-center">{{ $sale->tours_count }}</td>
                <td>
                    @if ($sale->ends_at->isPast())<span class="badge text-bg-secondary">Ended</span>
                    @elseif ($sale->starts_at->isFuture())<span class="badge text-bg-info">Scheduled</span>
                    @elseif ($sale->is_active)<span class="badge text-bg-success">Running</span>
                    @else<span class="badge text-bg-secondary">Off</span>@endif
                </td>
                <td class="text-end">
                    <form method="POST" action="{{ route('admin.flash-sales.destroy', $sale->id) }}"
                          onsubmit="return confirm('Delete this sale? Tour prices revert immediately.')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-5">No flash sales.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="panel-foot">{{ $sales->links() }}</div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="add" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" method="POST" action="{{ route('admin.flash-sales.store') }}">
            @csrf
            <div class="modal-header"><h5 class="modal-title">New flash sale</h5></div>
            <div class="modal-body row g-2">
                <div class="col-md-6"><label class="form-label small">Name</label><input name="name" class="form-control" required></div>
                <div class="col-md-3">
                    <label class="form-label small">Type</label>
                    <select name="discount_type" class="form-select"><option value="percentage">Percentage</option><option value="fixed">Fixed</option></select>
                </div>
                <div class="col-md-3"><label class="form-label small">Value</label><input type="number" step="0.01" name="discount_value" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label small">Starts</label><input type="datetime-local" name="starts_at" class="form-control" required></div>
                <div class="col-md-6"><label class="form-label small">Ends</label><input type="datetime-local" name="ends_at" class="form-control" required></div>
                <div class="col-12">
                    <label class="form-label small">Tours</label>
                    <select name="tour_ids[]" class="form-select" multiple size="8">
                        @foreach ($tours as $tour)<option value="{{ $tour->id }}">{{ $tour->title }}</option>@endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Create sale</button>
            </div>
        </form>
    </div>
</div>
@endpush
