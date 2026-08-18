@extends('layouts.admin')
@section('title', 'Tour categories')
@section('actions')<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add">Add category</button>@endsection

@section('content')
<div class="panel" x-data="dataTable('{{ route('admin.categories.index') }}', '{{ route('admin.categories.bulk') }}')">
    <header class="panel-head d-flex gap-2">
        <input type="search" class="form-control form-control-sm w-auto" placeholder="Search"
               x-model.debounce.400ms="filters.keyword" @input="reload()">
        <div class="ms-auto d-flex gap-2" x-show="selected.length" x-cloak>
            <button class="btn btn-sm btn-outline-secondary" @click="bulk('activate')">Activate</button>
            <button class="btn btn-sm btn-outline-danger" @click="bulk('delete')">Delete</button>
        </div>
    </header>
    <div id="table-target">@include('admin.cms.categories.partials.table', ['records' => $records])</div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="add" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Add a category</h5></div>
            <div class="modal-body row g-2">
                <div class="col-12"><label class="form-label small">Name</label><input name="name" class="form-control" required></div>
                <div class="col-6">
                    <label class="form-label small">Parent</label>
                    <select name="parent_id" class="form-select"><option value="">Top level</option>
                        @foreach ($records as $record)<option value="{{ $record->id }}">{{ $record->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-6"><label class="form-label small">Icon</label><input name="icon" class="form-control" placeholder="sun"></div>
                <div class="col-6"><label class="form-label small">Sort order</label><input type="number" name="sort_order" class="form-control" value="0"></div>
                <div class="col-6 d-flex align-items-end">
                    <div class="form-check"><input class="form-check-input" type="checkbox" name="show_in_menu" value="1" id="menu" checked><label class="form-check-label small" for="menu">Show in menu</label></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endpush
