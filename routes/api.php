<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\CatalogApiController;
use App\Http\Controllers\Api\TourApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API v1
|--------------------------------------------------------------------------
| Sanctum-token based. Everything the Blade frontend does, the API can do, so
| the Figma rebuild may be a Blade theme or a headless SPA without backend work.
*/

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    // Public ---------------------------------------------------------------
    Route::get('settings', [CatalogApiController::class, 'settings'])->name('settings');
    Route::get('tours', [TourApiController::class, 'index'])->name('tours.index');
    Route::get('tours/featured', [TourApiController::class, 'featured'])->name('tours.featured');
    Route::get('tours/facets', [TourApiController::class, 'facets'])->name('tours.facets');
    Route::get('tours/{slug}', [TourApiController::class, 'show'])->name('tours.show');
    Route::get('tours/{slug}/reviews', [CatalogApiController::class, 'reviews'])->name('tours.reviews');
    Route::get('categories', [CatalogApiController::class, 'categories'])->name('categories');
    Route::get('destinations', [CatalogApiController::class, 'destinations'])->name('destinations');

    Route::post('bookings/quote', [BookingApiController::class, 'quote'])->middleware('throttle:60,1')->name('bookings.quote');
    Route::post('bookings', [BookingApiController::class, 'store'])->middleware('throttle:10,1')->name('bookings.store');

    // Auth -----------------------------------------------------------------
    Route::post('auth/register', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('auth.register');
    Route::post('auth/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('auth.login');

    // Protected ------------------------------------------------------------
    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('auth/me', [AuthController::class, 'me'])->name('auth.me');
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::get('bookings', [BookingApiController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [BookingApiController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}/cancel', [BookingApiController::class, 'cancel'])->name('bookings.cancel');
    });
});
