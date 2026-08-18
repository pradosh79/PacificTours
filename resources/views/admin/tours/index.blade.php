@extends('layouts.admin')

@section('title', 'Tours')

@section('actions')
    <a href="{{ route('admin.tours.create') }}" class="btn btn-primary btn-sm">Add tour</a>
@endsection

@section('content')
<div class="panel" x-data="dataTable('{{ route('admin.tours.index') }}', '{{ route('admin.tours.bulk') }}')">
    <header class="panel-head d-flex flex-wrap gap-2 align-items-center">
        <input type="search" class="form-control form-control-sm w-auto" placeholder="Search tours"
               x-model.debounce.400ms="filters.keyword" @input="reload()">

        <select class="form-select form-select-sm w-auto" x-model="filters.status" @change="reload()">
            <option value="">All statuses</option>
            @foreach (\App\Enums\TourStatus::cases() as $status)
                <option value="{{ $status->value }}">{{ Str::headline($status->value) }}</option>
            @endforeach
        </select>

        <div class="ms-auto d-flex gap-2" x-show="selected.length" x-cloak>
            <span class="small align-self-center" x-text="`${selected.length} selected`"></span>
            <button class="btn btn-sm btn-outline-secondary" @click="bulk('publish')">Publish</button>
            <button class="btn btn-sm btn-outline-secondary" @click="bulk('feature')">Feature</button>
            <button class="btn btn-sm btn-outline-danger" @click="bulk('delete')">Delete</button>
        </div>
    </header>

    <div id="table-target">
        @include('admin.tours.partials.table', ['tours' => $tours])
    </div>
</div>
@endsection
