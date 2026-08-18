@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="h3 mb-4">Destinations</h1>
    <div class="row g-3">
        @foreach ($destinations as $destination)
            <div class="col-6 col-md-4 col-lg-3">
                <a class="d-block border rounded overflow-hidden text-decoration-none h-100" href="{{ route('destinations.show', $destination->slug) }}">
                    <img src="{{ upload_url($destination->thumbnail) }}" alt="" class="w-100" style="height:150px;object-fit:cover" loading="lazy">
                    <div class="p-2">
                        <span class="fw-semibold d-block">{{ $destination->name }}</span>
                        <span class="small text-muted">{{ $destination->tours_count }} tours</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $destinations->links() }}</div>
</div>
@endsection
