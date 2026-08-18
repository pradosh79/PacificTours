@extends('layouts.admin')
@section('title', $title)

@section('actions')
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#crud-add">+ Add</button>
@endsection

@php
    /* Only scalar columns are editable inline. Dotted paths like "country.name"
       are read-only relation columns, so skip them in the form. */
    $editableFields = collect($columns)->reject(fn ($label, $field) => str_contains($field, '.'))->toArray();
    $fileFields     = $fileFields ?? [];
    $textareaFields = $textareaFields ?? [];
    $selectOptions  = $selectOptions ?? [];
@endphp

@section('content')
<div class="panel"
     x-data="Object.assign(
        dataTable('{{ route($routeName.'.index') }}', '{{ route($routeName.'.bulk') }}'),
        {
            editing: null,
            editUrl: '',
            openEdit(record) {
                this.editing = { ...record };
                this.editUrl = '{{ route($routeName.'.index') }}/' + record.id;
                new bootstrap.Modal(document.getElementById('crud-edit')).show();
            }
        })">
    <header class="panel-head d-flex gap-2">
        <input type="search" class="form-control form-control-sm w-auto" placeholder="Search"
               x-model.debounce.400ms="filters.keyword" @input="reload()">
        <div class="ms-auto d-flex gap-2" x-show="selected.length" x-cloak>
            <span class="small align-self-center" x-text="`${selected.length} selected`"></span>
            <button class="btn btn-sm btn-outline-secondary" @click="bulk('activate')">Activate</button>
            <button class="btn btn-sm btn-outline-secondary" @click="bulk('deactivate')">Deactivate</button>
            <button class="btn btn-sm btn-outline-danger"  @click="bulk('delete')">Delete</button>
        </div>
    </header>

    <div id="table-target">
        @include('admin.crud.partials.table',
                 compact('records', 'columns', 'routeName', 'fileFields'))
    </div>

    {{-- Reusable EDIT modal — one instance, populated by Alpine. --}}
    <div class="modal fade" id="crud-edit" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" :action="editUrl" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header">
                    <h5 class="modal-title">Edit {{ Str::lower(Str::singular($title)) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-2">
                    @foreach ($editableFields as $field => $label)
                        <div class="col-12">
                            <label class="form-label small">{{ $label }}</label>

                            @if (in_array($field, $fileFields, true))
                                {{-- Replaceable image upload with a preview of the currently stored file. --}}
                                <input type="file" name="{{ $field }}" accept="image/*" class="form-control">
                                <template x-if="editing['{{ $field }}']">
                                    <div class="mt-1">
                                        <img :src="'/storage/' + editing['{{ $field }}']"
                                             alt="" style="max-height:80px" class="rounded border">
                                        <p class="form-text small mb-0">Leave blank to keep the current file.</p>
                                    </div>
                                </template>
                            @elseif (isset($selectOptions[$field]))
                                <select name="{{ $field }}" class="form-select" x-model="editing['{{ $field }}']">
                                    @foreach ($selectOptions[$field] as $value => $optionLabel)
                                        <option value="{{ $value }}">{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                            @elseif (in_array($field, $textareaFields, true))
                                <textarea name="{{ $field }}" rows="3" class="form-control"
                                          x-model="editing['{{ $field }}']"></textarea>
                            @else
                                <input name="{{ $field }}" class="form-control"
                                       x-model="editing['{{ $field }}']">
                            @endif
                        </div>
                    @endforeach

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                   id="edit-active" x-model="editing.is_active">
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
{{-- Reusable ADD modal --}}
<div class="modal fade" id="crud-add" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route($routeName.'.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add {{ Str::lower(Str::singular($title)) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-2">
                @foreach ($editableFields as $field => $label)
                    <div class="col-12">
                        <label class="form-label small">{{ $label }}</label>

                        @if (in_array($field, $fileFields, true))
                            <input type="file" name="{{ $field }}" accept="image/*" class="form-control">
                        @elseif (isset($selectOptions[$field]))
                            <select name="{{ $field }}" class="form-select">
                                @foreach ($selectOptions[$field] as $value => $optionLabel)
                                    <option value="{{ $value }}">{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        @elseif (in_array($field, $textareaFields, true))
                            <textarea name="{{ $field }}" rows="3" class="form-control"></textarea>
                        @else
                            <input name="{{ $field }}" class="form-control" @required($loop->first)>
                        @endif
                    </div>
                @endforeach
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="add-active" checked>
                        <label class="form-check-label small" for="add-active">Active</label>
                    </div>
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
