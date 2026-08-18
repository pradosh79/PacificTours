<form class="panel-head d-flex flex-wrap gap-2 align-items-end">
    <div>
        <label class="form-label small mb-0">Range</label>
        <select name="range" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
            @foreach (['today' => 'Today', 'week' => 'This week', 'month' => 'This month', 'quarter' => 'This quarter', 'year' => 'This year', 'custom' => 'Custom'] as $value => $label)
                <option value="{{ $value }}" @selected(request('range', 'month') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div><label class="form-label small mb-0">From</label><input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}"></div>
    <div><label class="form-label small mb-0">To</label><input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}"></div>
    <button class="btn btn-sm btn-outline-secondary">Apply</button>

    @can('report.export')
        <div class="ms-auto d-flex gap-1">
            <a class="btn btn-sm btn-outline-secondary" href="{{ request()->fullUrlWithQuery(['export' => null]) && route('admin.reports.export', ['type' => $type, 'format' => 'xlsx']) }}?{{ http_build_query(request()->except('page')) }}">Excel</a>
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.reports.export', ['type' => $type, 'format' => 'pdf']) }}?{{ http_build_query(request()->except('page')) }}">PDF</a>
        </div>
    @endcan
</form>
