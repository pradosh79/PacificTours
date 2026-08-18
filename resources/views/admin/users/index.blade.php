@extends('layouts.admin')
@section('title', $type === 'staff' ? 'Staff' : 'Customers')

@section('actions')
    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.users.index', ['type' => $type === 'staff' ? 'customers' : 'staff']) }}">
        Show {{ $type === 'staff' ? 'customers' : 'staff' }}
    </a>
    @can('create', App\Models\User::class)
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#new-user">Add user</button>
    @endcan
@endsection

@section('content')
<div class="panel">
    <header class="panel-head">
        <form class="d-flex gap-2">
            <input type="hidden" name="type" value="{{ $type }}">
            <input name="keyword" class="form-control form-control-sm w-auto" placeholder="Name, email or phone" value="{{ request('keyword') }}">
            <button class="btn btn-sm btn-outline-secondary">Search</button>
        </form>
    </header>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Joined</th><th></th></tr></thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td class="fw-semibold">{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?: '—' }}</td>
                    <td>{{ $user->getRoleNames()->map(fn ($r) => Str::headline($r))->join(', ') }}</td>
                    <td><span class="badge text-bg-light">{{ Str::headline($user->status->value) }}</span></td>
                    <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-end"><a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.users.show', $user->uuid) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">Nobody matches that search.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="panel-foot">{{ $users->withQueryString()->links() }}</div>
</div>
@endsection

@push('modals')
<div class="modal fade" id="new-user" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Add a user</h5></div>
            <div class="modal-body row g-2">
                <div class="col-6"><label class="form-label small">First name</label><input name="first_name" class="form-control" required></div>
                <div class="col-6"><label class="form-label small">Last name</label><input name="last_name" class="form-control"></div>
                <div class="col-12"><label class="form-label small">Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="col-6"><label class="form-label small">Phone</label><input name="phone" class="form-control"></div>
                <div class="col-6">
                    <label class="form-label small">Role</label>
                    <select name="role" class="form-select" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ Str::headline($role->name) }}</option>
                        @endforeach
                        <option value="customer">Customer</option>
                    </select>
                </div>
                <div class="col-6"><label class="form-label small">Password</label><input type="password" name="password" class="form-control" required></div>
                <div class="col-6"><label class="form-label small">Confirm</label><input type="password" name="password_confirmation" class="form-control" required></div>
                <div class="col-12">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select">
                        @foreach (\App\Enums\UserStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected($status->value === 'active')>{{ Str::headline($status->value) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Create user</button>
            </div>
        </form>
    </div>
</div>
@endpush
