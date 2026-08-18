<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['nullable', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'phone'      => ['nullable', 'string', 'max:32'],
            'password'   => ['required', 'confirmed', Password::min(10)->mixedCase()->numbers()],
        ]);

        $user = User::create([...$data, 'password' => Hash::make($data['password'])]);
        $user->assignRole(RoleName::Customer->value);
        event(new \Illuminate\Auth\Events\Registered($user));

        return $this->ok([
            'token' => $user->createToken('api')->plainTextToken,
            'user'  => ['id' => $user->uuid, 'name' => $user->full_name, 'email' => $user->email],
        ], 'Account created. Check your inbox to verify your email.', 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            'device'   => ['nullable', 'string', 'max:60'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->fail('Those credentials do not match our records.', 401);
        }

        if (! $user->status->canLogin()) {
            return $this->fail('This account is not active.', 403);
        }

        $user->forceFill(['last_login_at' => now(), 'last_login_ip' => $request->ip()])->save();

        return $this->ok([
            'token' => $user->createToken($data['device'] ?? 'api')->plainTextToken,
            'user'  => ['id' => $user->uuid, 'name' => $user->full_name, 'email' => $user->email, 'roles' => $user->getRoleNames()],
        ]);
    }

    public function me(Request $request)
    {
        return $this->ok($request->user()->load('profile'));
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok(message: 'Signed out.');
    }
}
