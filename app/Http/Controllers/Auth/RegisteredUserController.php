<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['nullable', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'      => ['nullable', 'string', 'max:32'],
            'password'   => ['required', 'confirmed', Password::min(10)->mixedCase()->numbers()],
            'terms'      => ['accepted'],
        ]);

        $user = User::create([
            ...collect($data)->except('terms')->toArray(),
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole(RoleName::Customer->value);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('customer.dashboard');
    }
}
