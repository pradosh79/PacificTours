@extends('layouts.admin')
@section('title', 'Widgets')

@section('content')
@foreach ($widgets as $area => $group)
    <section class="panel mb-3">
        <header class="panel-head"><h2 class="h6 mb-0">{{ Str::headline($area) }}</h2></header>
        <div class="panel-body">
            @foreach ($group as $widget)
                <form method="POST" action="{{ route('admin.widgets.update', $widget->id) }}" class="row g-2 mb-3 border-bottom pb-3">
                    @csrf @method('PUT')
                    <div class="col-md-4"><label class="form-label small">Title</label><input name="title" class="form-control form-control-sm" value="{{ $widget->title }}"></div>
                    <div class="col-md-6">
                        <label class="form-label small">Content (JSON)</label>
                        <textarea name="content_raw" rows="3" class="form-control form-control-sm font-monospace">{{ json_encode($widget->content, JSON_PRETTY_PRINT) }}</textarea>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="w{{ $widget->id }}" @checked($widget->is_active)>
                            <label class="form-check-label small" for="w{{ $widget->id }}">On</label>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary">Save</button>
                    </div>
                </form>
            @endforeach
        </div>
    </section>
@endforeach
@endsection
