<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ChangePasswordRequest;
use App\Http\Requests\Customer\UpdateProfileRequest;
use App\Models\Country;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct(private readonly MediaService $media) {}

    public function edit(Request $request)
    {
        return view('customer.profile', [
            'user'      => $request->user()->load('profile'),
            'countries' => Country::active()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->safe()->except(['profile', 'avatar']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->media->replace($user->avatar, $request->file('avatar'), 'avatars');
        }

        // Changing the email drops verification until the new address is confirmed.
        if ($data['email'] !== $user->email) {
            $data['email_verified_at'] = null;
        }

        $user->update($data);
        $user->profile()->updateOrCreate([], $request->input('profile', []));

        if ($user->wasChanged('email')) {
            $user->sendEmailVerificationNotification();
        }

        return back()->with('success', 'Profile updated.');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $request->user()->update(['password' => Hash::make($request->string('password')->toString())]);

        return back()->with('success', 'Password changed.');
    }
}
