@extends('layouts.app')
@section('content')
<article class="container py-5" style="max-width:760px">
    <h1 class="h3">{{ $page->title }}</h1>
    <div class="mt-4">{!! $page->content !!}</div>
</article>
@endsection
