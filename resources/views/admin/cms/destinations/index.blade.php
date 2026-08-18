@extends('layouts.admin')
@section('title', 'Destinations')
@section('actions')<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add">Add destination</button>@endsection

@section('content')
<div class="panel"
     x-data="Object.assign(
        dataTable('{{ route('admin.destinations.index') }}', '{{ route('admin.destinations.bulk') }}'),
        {
            editing: null,
            editUrl: '',
            openEdit(record) {
                this.editing = { ...record };
                this.editUrl = '{{ route('admin.destinations.index') }}/' + record.id;
                new bootstrap.Modal(document.getElementById('edit-destination')).show();
            }
        })">
    <header class="panel-head d-flex gap-2">
        <input type="search" class="form-control form-control-sm w-auto" placeholder="Search"
               x-model.debounce.400ms="filters.keyword" @input="reload()">
        <div class="ms-auto d-flex gap-2" x-show="selected.length" x-cloak>
            <button class="btn btn-sm btn-outline-secondary" @click="bulk('activate')">Activate</button>
            <button class="btn btn-sm btn-outline-danger" @click="bulk('delete')">Delete</button>
        </div>
    </header>
    <div id="table-target">@include('admin.cms.destinations.partials.table', ['records' => $records])</div>

    {{-- Reusable EDIT modal — one instance, driven by Alpine state so every row's
         "Edit" button opens it pre-filled without a page reload. --}}
    <div class="modal fade" id="edit-destination" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" :action="editUrl" enctype="multipart/form-data" x-show="editing" x-cloak>
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header">
                    <h5 class="modal-title">Edit destination</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-2">
                    <div class="col-12"><label class="form-label small">Name</label><input name="name" class="form-control" required x-model="editing.name"></div>
                    <div class="col-6">
                        <label class="form-label small">Country</label>
                        <select name="country_id" class="form-select" required x-model="editing.country_id">
                            @foreach (\App\Models\Country::orderBy('name')->get() as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6"><label class="form-label small">Best time to visit</label><input name="best_time_to_visit" class="form-control" x-model="editing.best_time_to_visit"></div>
                    <div class="col-12"><label class="form-label small">Short description</label><input name="short_description" class="form-control" maxlength="255" x-model="editing.short_description"></div>

                    <div class="col-6">
                        <label class="form-label small">Thumbnail</label>
                        <input type="file" name="thumbnail" accept="image/*" class="form-control">
                        <template x-if="editing?.thumbnail_url">
                            <p class="form-text small mb-0">Current: <a :href="editing.thumbnail_url" target="_blank">view</a> — choose a file to replace it.</p>
                        </template>
                    </div>
                    <div class="col-6">
                        <label class="form-label small">Banner</label>
                        <input type="file" name="banner" accept="image/*" class="form-control">
                        <template x-if="editing?.banner_url">
                            <p class="form-text small mb-0">Current: <a :href="editing.banner_url" target="_blank">view</a> — choose a file to replace it.</p>
                        </template>
                    </div>

                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="edit-featured" x-model="editing.is_featured">
                            <label class="form-check-label small" for="edit-featured">Featured</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="edit-active" x-model="editing.is_active">
                            <label class="form-check-label small" for="edit-active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="add" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Add a destination</h5></div>
            <div class="modal-body row g-2">
                <div class="col-12"><label class="form-label small">Name</label><input name="name" class="form-control" required></div>
                <div class="col-6">
                    <label class="form-label small">Country</label>
                    <select name="country_id" class="form-select" required>
                        @foreach (\App\Models\Country::orderBy('name')->get() as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6"><label class="form-label small">Best time to visit</label><input name="best_time_to_visit" class="form-control" placeholder="May – September"></div>
                <div class="col-12"><label class="form-label small">Short description</label><input name="short_description" class="form-control" maxlength="255"></div>
                <div class="col-6"><label class="form-label small">Thumbnail</label><input type="file" name="thumbnail" accept="image/*" class="form-control"></div>
                <div class="col-6"><label class="form-label small">Banner</label><input type="file" name="banner" accept="image/*" class="form-control"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endpush
