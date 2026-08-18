<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Webhooks skip CSRF, so they get their own guard: signature headers must be
 * present before the payload reaches the controller.
 */
class VerifyWebhookSource
{
    public function handle(Request $request, Closure $next, string $gateway): Response
    {
        $header = match ($gateway) {
            'stripe' => 'stripe-signature',
            'paypal' => 'paypal-transmission-sig',
            default  => null,
        };

        abort_if($header && ! $request->hasHeader($header), 400, 'Missing signature.');

        return $next($request);
    }
}
