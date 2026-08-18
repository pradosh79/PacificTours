@extends('layouts.admin')
@section('title', 'Galleries')
@section('actions')<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add">New gallery</button>@endsection

@section('content')
<div class="row g-3">
    @forelse ($galleries as $gallery)
        <div class="col-md-4">
            <article class="panel h-100">
                <div class="panel-body">
                    <h2 class="h6"><a href="{{ route('admin.galleries.show', $gallery->uuid) }}">{{ $gallery->title }}</a></h2>
                    <p class="small text-muted mb-0">{{ $gallery->images_count }} images</p>
                </div>
            </article>
        </div>
    @empty
        <div class="col-12"><p class="text-muted text-center py-5">No galleries yet.</p></div>
    @endforelse
</div>
<div class="mt-3">{{ $galleries->links() }}</div>
@endsection

@push('modals')
<div class="modal fade" id="add" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('admin.galleries.store') }}">
            @csrf
            <div class="modal-header"><h5 class="modal-title">New gallery</h5></div>
            <div class="modal-body">
                <label class="form-label small">Title</label>
                <input name="title" class="form-control mb-2" required>
                <label class="form-label small">Description</label>
                <textarea name="description" rows="3" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endpush
