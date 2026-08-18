@extends('layouts.admin')
@section('title', 'Coupons')
@section('actions')<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add">Add coupon</button>@endsection

@section('content')
<div class="panel" x-data="dataTable('{{ route('admin.coupons.index') }}', '{{ route('admin.coupons.bulk') }}')">
    <header class="panel-head d-flex gap-2">
        <input type="search" class="form-control form-control-sm w-auto" placeholder="Search code"
               x-model.debounce.400ms="filters.keyword" @input="reload()">
        <div class="ms-auto d-flex gap-2" x-show="selected.length" x-cloak>
            <button class="btn btn-sm btn-outline-secondary" @click="bulk('deactivate')">Deactivate</button>
            <button class="btn btn-sm btn-outline-danger" @click="bulk('delete')">Delete</button>
        </div>
    </header>
    <div id="table-target">@include('admin.cms.coupons.partials.table', ['records' => $records])</div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="add" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Create a coupon</h5></div>
            <div class="modal-body row g-2">
                <div class="col-md-4"><label class="form-label small">Code</label><input name="code" class="form-control text-uppercase" required></div>
                <div class="col-md-8"><label class="form-label small">Internal name</label><input name="name" class="form-control"></div>
                <div class="col-md-3">
                    <label class="form-label small">Type</label>
                    <select name="type" class="form-select"><option value="percentage">Percentage</option><option value="fixed">Fixed amount</option></select>
                </div>
                <div class="col-md-3"><label class="form-label small">Value</label><input type="number" step="0.01" name="value" class="form-control" required></div>
                <div class="col-md-3"><label class="form-label small">Min spend</label><input type="number" step="0.01" name="min_spend" class="form-control" value="0"></div>
                <div class="col-md-3">
                    <label class="form-label small">Max discount</label>
                    <input type="number" step="0.01" name="max_discount" class="form-control" placeholder="none">
                    <p class="form-text small">Caps a percentage coupon.</p>
                </div>
                <div class="col-md-3"><label class="form-label small">Total uses</label><input type="number" name="usage_limit" class="form-control" placeholder="unlimited"></div>
                <div class="col-md-3"><label class="form-label small">Uses per customer</label><input type="number" name="usage_limit_per_user" class="form-control" value="1" required></div>
                <div class="col-md-3"><label class="form-label small">Starts</label><input type="datetime-local" name="starts_at" class="form-control"></div>
                <div class="col-md-3"><label class="form-label small">Expires</label><input type="datetime-local" name="expires_at" class="form-control"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Create coupon</button>
            </div>
        </form>
    </div>
</div>
@endpush
