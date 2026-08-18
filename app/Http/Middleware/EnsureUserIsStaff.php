<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gate for everything under /admin. Role checks beyond this live in policies.
 */
class EnsureUserIsStaff
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_if(! $user || ! $user->isStaff(), 403, 'This area is for Pacific Tours staff.');
        abort_if($user->status !== UserStatus::Active, 403, 'This account is not active.');

        return $next($request);
    }
}
