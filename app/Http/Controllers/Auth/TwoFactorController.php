<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

/**
 * TOTP challenge. The users table already carries two_factor_secret,
 * two_factor_recovery_codes and two_factor_confirmed_at, so enabling this is a
 * matter of installing a TOTP provider (Fortify ships one) and turning the
 * routes on — no schema change.
 */
class TwoFactorController extends Controller
{
    public function show(Request $request)
    {
        abort_unless($request->session()->has('two_factor.user_id'), 403);

        return view('auth.two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => ['required', 'string', 'digits:6']]);

        $user = \App\Models\User::findOrFail($request->session()->get('two_factor.user_id'));

        $valid = app(\Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider::class)
            ->verify(Crypt::decryptString($user->two_factor_secret), $request->string('code')->toString());

        if (! $valid) {
            throw ValidationException::withMessages(['code' => __('That code is not valid.')]);
        }

        $request->session()->forget('two_factor.user_id');
        auth()->login($user, $request->session()->pull('two_factor.remember', false));
        $request->session()->regenerate();

        return redirect()->intended(route('customer.dashboard'));
    }
}
