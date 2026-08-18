@extends('layouts.admin')
@section('title', 'Menus')

@section('content')
<div class="row g-3">
    <div class="col-lg-3">
        <nav class="list-group">
            @foreach ($menus as $item)
                <a class="list-group-item list-group-item-action {{ $menu->id === $item->id ? 'active' : '' }}"
                   href="{{ route('admin.menus.index', ['location' => $item->location]) }}">
                    {{ $item->name }}
                </a>
            @endforeach
        </nav>
    </div>

    <div class="col-lg-5">
        <section class="panel">
            <header class="panel-head"><h2 class="h6 mb-0">{{ $menu->name }} structure</h2></header>
            <ul class="panel-body list-unstyled mb-0" id="menu-tree" data-reorder="{{ route('admin.menus.reorder', $menu->id) }}">
                @forelse ($menu->items as $item)
                    <li class="border rounded p-2 mb-2" data-id="{{ $item->id }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ $item->label }} <code class="small">{{ $item->resolveUrl() }}</code></span>
                            <form method="POST" action="{{ route('admin.menus.items.destroy', $item->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-link text-danger">Remove</button>
                            </form>
                        </div>

                        @if ($item->children->isNotEmpty())
                            <ul class="list-unstyled ms-4 mt-2 mb-0">
                                @foreach ($item->children as $child)
                                    <li class="border rounded p-2 mb-1 d-flex justify-content-between" data-id="{{ $child->id }}">
                                        <span class="small">{{ $child->label }}</span>
                                        <form method="POST" action="{{ route('admin.menus.items.destroy', $child->id) }}">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-link text-danger p-0">Remove</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @empty
                    <li class="text-muted small">This menu is empty.</li>
                @endforelse
            </ul>
        </section>
    </div>

    <div class="col-lg-4">
        <section class="panel">
            <header class="panel-head"><h2 class="h6 mb-0">Add an item</h2></header>
            <form class="panel-body" method="POST" action="{{ route('admin.menus.items.store', $menu->id) }}">
                @csrf
                <label class="form-label small">Label</label>
                <input name="label" class="form-control form-control-sm mb-2" required>

                <label class="form-label small">Links to</label>
                <select name="type" class="form-select form-select-sm mb-2">
                    @foreach (['custom' => 'Custom URL', 'page' => 'CMS page', 'category' => 'Tour category', 'destination' => 'Destination', 'blog' => 'Blog'] as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>

                <label class="form-label small">URL</label>
                <input name="url" class="form-control form-control-sm mb-2" placeholder="/tours">

                <label class="form-label small">Nest under</label>
                <select name="parent_id" class="form-select form-select-sm mb-3">
                    <option value="">Top level</option>
                    @foreach ($menu->items as $item)
                        <option value="{{ $item->id }}">{{ $item->label }}</option>
                    @endforeach
                </select>

                <button class="btn btn-sm btn-primary w-100">Add item</button>
            </form>
        </section>
    </div>
</div>
@endsection
