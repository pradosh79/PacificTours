@extends('customer.layout')
@section('heading', 'Saved tours')

@section('panel')
<div class="row g-3">
    @forelse ($tours as $wishlist)
        <div class="col-md-6 col-lg-4">
            @include('web.tours.partials.card', ['tour' => $wishlist->tour])
            <form method="POST" action="{{ route('customer.wishlist.toggle', $wishlist->tour->uuid) }}" class="mt-1">
                @csrf
                <button class="btn btn-sm btn-link text-danger">Remove</button>
            </form>
        </div>
    @empty
        <p class="text-muted py-5 text-center">
            Nothing saved yet. Tap "Save for later" on any tour.
        </p>
    @endforelse
</div>
<div class="mt-3">{{ $tours->links() }}</div>
@endsection
