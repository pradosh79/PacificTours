<?php

declare(strict_types=1);

use App\Http\Middleware\EnsureUserIsStaff;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\ShareCmsData;
use App\Http\Middleware\VerifyWebhookSource;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            SetLocale::class,
            SecurityHeaders::class,
        ]);

        $middleware->api(prepend: [
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'staff'          => EnsureUserIsStaff::class,
            'role'           => Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission'     => Spatie\Permission\Middleware\PermissionMiddleware::class,
            'webhook.source' => VerifyWebhookSource::class,
        ]);

        $middleware->group('web.cms', ['web', ShareCmsData::class]);

        // Gateways sign their own payloads; Laravel's CSRF token cannot apply.
        $middleware->validateCsrfTokens(except: ['webhooks/*']);

        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (App\Exceptions\BookingException $e, $request) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 409)
                : back()->withInput()->with('error', $e->getMessage());
        });

        $exceptions->render(function (App\Exceptions\PaymentException $e, $request) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 402)
                : back()->with('error', $e->getMessage());
        });

        $exceptions->render(function (App\Exceptions\CouponException $e, $request) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 422)
                : back()->withInput()->with('error', $e->getMessage());
        });

        $exceptions->dontReport([
            App\Exceptions\CouponException::class,
        ]);
    })
    ->withProviders([
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RepositoryServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
    ])
    ->create();
