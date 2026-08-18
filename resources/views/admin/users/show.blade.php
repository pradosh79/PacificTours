@extends('layouts.admin')
@section('title', $user->full_name)

@section('content')
<div class="row g-3">
    <div class="col-lg-5">
        <section class="panel">
            <header class="panel-head"><h2 class="h6 mb-0">Account</h2></header>
            <form class="panel-body row g-2" method="POST" action="{{ route('admin.users.update', $user->uuid) }}">
                @csrf @method('PUT')
                <div class="col-6"><label class="form-label small">First name</label><input name="first_name" class="form-control" value="{{ $user->first_name }}" required></div>
                <div class="col-6"><label class="form-label small">Last name</label><input name="last_name" class="form-control" value="{{ $user->last_name }}"></div>
                <div class="col-12"><label class="form-label small">Email</label><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></div>
                <div class="col-6"><label class="form-label small">Phone</label><input name="phone" class="form-control" value="{{ $user->phone }}"></div>
                <div class="col-6">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select">
                        @foreach (\App\Enums\UserStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected($user->status === $status)>{{ Str::headline($status->value) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12"><button class="btn btn-sm btn-primary mt-2">Save</button></div>
            </form>
        </section>

        @if ($user->profile)
            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Travel profile</h2></header>
                <dl class="panel-body row small mb-0">
                    <dt class="col-5">Date of birth</dt><dd class="col-7">{{ $user->profile->date_of_birth?->format('d M Y') ?? '—' }}</dd>
                    <dt class="col-5">Nationality</dt><dd class="col-7">{{ $user->profile->nationality ?: '—' }}</dd>
                    <dt class="col-5">Passport</dt><dd class="col-7">{{ $user->profile->passport_number ?: '—' }}</dd>
                    <dt class="col-5">Emergency</dt><dd class="col-7">{{ $user->profile->emergency_contact_name ?: '—' }} {{ $user->profile->emergency_contact_phone }}</dd>
                    <dt class="col-5">Dietary</dt><dd class="col-7">{{ $user->profile->dietary_requirements ?: '—' }}</dd>
                </dl>
            </section>
        @endif
    </div>

    <div class="col-lg-7">
        <div class="row g-3 mb-3">
            <div class="col-6"><article class="stat-card"><p class="stat-value">{{ $user->bookings_count }}</p><p class="stat-label">Bookings</p></article></div>
            <div class="col-6"><article class="stat-card"><p class="stat-value">{{ money($user->bookings_sum_grand_total ?? 0) }}</p><p class="stat-label">Lifetime value</p></article></div>
        </div>

        <section class="panel">
            <header class="panel-head"><h2 class="h6 mb-0">Booking history</h2></header>
            <table class="table table-sm mb-0">
                <thead><tr><th>Booking</th><th>Tour</th><th>Travel</th><th class="text-end">Total</th><th>Status</th></tr></thead>
                <tbody>
                @forelse ($bookings as $booking)
                    <tr>
                        <td><a href="{{ route('admin.bookings.show', $booking->uuid) }}">{{ $booking->booking_number }}</a></td>
                        <td class="text-truncate" style="max-width:12rem">{{ $booking->tour?->title }}</td>
                        <td>{{ $booking->travel_date->format('d M Y') }}</td>
                        <td class="text-end">{{ money($booking->grand_total) }}</td>
                        <td><span class="badge text-bg-{{ $booking->status->badge() }}">{{ $booking->status->label() }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center py-4">No bookings.</td></tr>
                @endforelse
                </tbody>
            </table>
        </section>
    </div>
</div>
@endsection
