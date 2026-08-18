@extends('layouts.admin')
@section('title', 'Roles & permissions')

@section('content')
<div class="alert alert-info small">
    Permissions come from <code>config/permission_map.php</code>. Adding a capability there and
    re-running the seeder makes it appear on this screen.
</div>

<div class="row g-3">
    @foreach ($roles as $role)
        <div class="col-lg-6">
            <section class="panel h-100">
                <header class="panel-head d-flex justify-content-between align-items-center">
                    <h2 class="h6 mb-0">{{ Str::headline($role->name) }}</h2>
                    <span class="small text-muted">{{ $role->users_count }} users</span>
                </header>

                @if ($role->name === 'super-admin')
                    <div class="panel-body">
                        <p class="small text-muted mb-0">
                            Holds every permission by design and cannot be edited — that is what
                            makes it a reliable recovery path if another role is misconfigured.
                        </p>
                    </div>
                @else
                    <form class="panel-body" method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                        @csrf @method('PUT')
                        @foreach ($permissions as $group => $items)
                            <fieldset class="mb-3">
                                <legend class="small fw-semibold">{{ Str::headline($group) }}</legend>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($items as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                   value="{{ $permission->name }}"
                                                   id="{{ $role->id }}-{{ $permission->id }}"
                                                   @checked($role->permissions->contains($permission))>
                                            <label class="form-check-label small" for="{{ $role->id }}-{{ $permission->id }}">
                                                {{ Str::afterLast($permission->name, '.') }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </fieldset>
                        @endforeach
                        <button class="btn btn-sm btn-primary">Save permissions</button>
                    </form>
                @endif
            </section>
        </div>
    @endforeach
</div>
@endsection
