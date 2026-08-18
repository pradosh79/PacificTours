@extends('layouts.app')
@section('content')
<div class="container py-5" style="max-width:820px">
    <h1 class="h3 mb-4">Frequently asked questions</h1>

    @foreach ($groups as $category => $faqs)
        <section class="mb-4">
            <h2 class="h5">{{ Str::headline($category ?: 'General') }}</h2>
            <div class="accordion" id="faq-{{ $loop->index }}">
                @foreach ($faqs as $faq)
                    @php $id = 'faq-'.$loop->parent->index.'-'.$loop->index; @endphp
                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#{{ $id }}">
                                {{ $faq->question }}
                            </button>
                        </h3>
                        <div id="{{ $id }}" class="accordion-collapse collapse" data-bs-parent="#faq-{{ $loop->parent->index }}">
                            <div class="accordion-body small">{!! $faq->answer !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
</div>
@endsection
