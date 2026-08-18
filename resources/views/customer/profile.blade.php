@extends('customer.layout')
@section('heading', 'Profile & password')

@section('panel')
<section class="border rounded p-3 mb-3">
    <h2 class="h6">Your details</h2>
    <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="row g-2">
        @csrf @method('PUT')
        <div class="col-md-6"><label class="form-label small">First name</label><input name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required></div>
        <div class="col-md-6"><label class="form-label small">Last name</label><input name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}"></div>
        <div class="col-md-6"><label class="form-label small">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
        <div class="col-md-6"><label class="form-label small">Phone</label><input name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"></div>
        <div class="col-md-6"><label class="form-label small">Profile photo</label><input type="file" name="avatar" accept="image/*" class="form-control"></div>

        <div class="col-12"><hr><h3 class="h6">Travel details</h3></div>
        <div class="col-md-4"><label class="form-label small">Date of birth</label><input type="date" name="profile[date_of_birth]" class="form-control" value="{{ old('profile.date_of_birth', $user->profile?->date_of_birth?->toDateString()) }}"></div>
        <div class="col-md-4"><label class="form-label small">Nationality</label><input name="profile[nationality]" class="form-control" value="{{ old('profile.nationality', $user->profile?->nationality) }}"></div>
        <div class="col-md-4"><label class="form-label small">Passport number</label><input name="profile[passport_number]" class="form-control" value="{{ old('profile.passport_number', $user->profile?->passport_number) }}"></div>
        <div class="col-md-4"><label class="form-label small">Passport expiry</label><input type="date" name="profile[passport_expiry]" class="form-control" value="{{ old('profile.passport_expiry', $user->profile?->passport_expiry?->toDateString()) }}"></div>
        <div class="col-md-4"><label class="form-label small">Emergency contact</label><input name="profile[emergency_contact_name]" class="form-control" value="{{ old('profile.emergency_contact_name', $user->profile?->emergency_contact_name) }}"></div>
        <div class="col-md-4"><label class="form-label small">Emergency phone</label><input name="profile[emergency_contact_phone]" class="form-control" value="{{ old('profile.emergency_contact_phone', $user->profile?->emergency_contact_phone) }}"></div>
        <div class="col-12"><label class="form-label small">Dietary requirements</label><textarea name="profile[dietary_requirements]" rows="2" class="form-control">{{ old('profile.dietary_requirements', $user->profile?->dietary_requirements) }}</textarea></div>

        <div class="col-12 form-check ms-1 mt-2">
            <input class="form-check-input" type="checkbox" name="profile[newsletter_opt_in]" value="1" id="news" @checked($user->profile?->newsletter_opt_in)>
            <label class="form-check-label small" for="news">Send me trip ideas by email</label>
        </div>

        <div class="col-12"><button class="btn btn-primary btn-sm mt-2">Save changes</button></div>
    </form>
</section>

<section class="border rounded p-3">
    <h2 class="h6">Change password</h2>
    <form method="POST" action="{{ route('customer.password.update') }}" class="row g-2">
        @csrf @method('PUT')
        <div class="col-md-4"><label class="form-label small">Current password</label><input type="password" name="current_password" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label small">New password</label><input type="password" name="password" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label small">Confirm</label><input type="password" name="password_confirmation" class="form-control" required></div>
        <div class="col-12"><button class="btn btn-outline-secondary btn-sm mt-2">Update password</button></div>
    </form>
</section>
@endsection
