@extends('layouts.admin')
@section('title', 'Bookings')

@section('actions')
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-sm btn-primary">New booking</a>
@endsection

@section('content')
<div class="panel" x-data="dataTable('{{ route('admin.bookings.index') }}', '{{ route('admin.bookings.index') }}')">
    <header class="panel-head d-flex flex-wrap gap-2">
        <input type="search" class="form-control form-control-sm w-auto" placeholder="Number, name or email"
               x-model.debounce.400ms="filters.keyword" @input="reload()">
        <select class="form-select form-select-sm w-auto" x-model="filters.status" @change="reload()">
            <option value="">All statuses</option>
            @foreach (\App\Enums\BookingStatus::cases() as $status)
                <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
        </select>
        <select class="form-select form-select-sm w-auto" x-model="filters.payment_status" @change="reload()">
            <option value="">Any payment state</option>
            @foreach (\App\Enums\PaymentStatus::cases() as $status)
                <option value="{{ $status->value }}">{{ Str::headline($status->value) }}</option>
            @endforeach
        </select>
        <input type="date" class="form-control form-control-sm w-auto" x-model="filters.date_from" @change="reload()">
        <input type="date" class="form-control form-control-sm w-auto" x-model="filters.date_to" @change="reload()">
    </header>

    <div id="table-target">@include('admin.bookings.partials.table', ['bookings' => $bookings])</div>
</div>
@endsection
