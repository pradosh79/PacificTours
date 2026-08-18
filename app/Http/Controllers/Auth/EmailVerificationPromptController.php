<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(
                $request->user()->hasRole(RoleName::staff()) ? route('admin.dashboard') : route('customer.dashboard')
            );
        }

        return view('auth.verify-email');
    }
}
