@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="h3 mb-4">Gallery</h1>
    @foreach ($galleries as $gallery)
        <section class="mb-5">
            <h2 class="h5">{{ $gallery->title }}</h2>
            <div class="row g-2">
                @foreach ($gallery->images as $image)
                    <div class="col-6 col-md-3">
                        <img src="{{ upload_url($image->path) }}" alt="{{ $image->caption }}"
                             class="w-100 rounded" style="height:180px;object-fit:cover" loading="lazy">
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
</div>
@endsection
