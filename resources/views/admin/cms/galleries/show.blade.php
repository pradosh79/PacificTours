@extends('layouts.admin')
@section('title', $gallery->title)

@section('content')
<section class="panel mb-3">
    <header class="panel-head"><h2 class="h6 mb-0">Upload images</h2></header>
    <form class="panel-body d-flex gap-2" method="POST" action="{{ route('admin.galleries.upload', $gallery->uuid) }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" multiple accept="image/*" class="form-control form-control-sm" required>
        <button class="btn btn-sm btn-primary">Upload</button>
    </form>
</section>

<div class="row g-2">
    @forelse ($gallery->images as $image)
        <div class="col-6 col-md-3">
            <div class="panel">
                <img src="{{ upload_url($image->path) }}" alt="" class="w-100" style="height:150px;object-fit:cover">
                <form class="p-2" method="POST" action="{{ route('admin.galleries.images.destroy', [$gallery->uuid, $image->id]) }}">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger w-100">Remove</button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-12"><p class="text-muted text-center py-5">No images yet.</p></div>
    @endforelse
</div>
@endsection
