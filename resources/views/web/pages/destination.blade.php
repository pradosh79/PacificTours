@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h1 class="h3">{{ $destination->name }}</h1>
    <p class="text-muted">{{ $destination->short_description }}</p>
    @if ($destination->description)<div class="mb-4">{!! $destination->description !!}</div>@endif
    @if ($destination->best_time_to_visit)
        <p class="small"><strong>Best time to visit:</strong> {{ $destination->best_time_to_visit }}</p>
    @endif

    <h2 class="h5 mt-4 mb-3">Tours in {{ $destination->name }}</h2>
    <div class="row g-3">
        @foreach ($tours as $tour)
            <div class="col-md-6 col-lg-4">@include('web.tours.partials.card', ['tour' => $tour])</div>
        @endforeach
    </div>
    <div class="mt-4">{{ $tours->links() }}</div>
</div>
@endsection
