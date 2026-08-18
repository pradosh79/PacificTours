<?php

declare(strict_types=1);

use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\BookingWizardController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\SeoController;
use App\Http\Controllers\Web\TourController;
use App\Http\Controllers\Web\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
| Route names are the contract with the frontend. A Figma rebuild replaces the
| Blade views behind these names without touching a single route or controller.
*/

Route::middleware(['web.cms'])->group(function (): void {
    Route::get('/', HomeController::class)->name('home');

    // Catalogue -------------------------------------------------------------
    Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
    Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');
    Route::get('/tours/{slug}/availability', [TourController::class, 'availability'])->name('tours.availability');
    Route::get('/search/suggest', [TourController::class, 'suggest'])->name('search.suggest');

    Route::get('/destinations', [PageController::class, 'destinations'])->name('destinations.index');
    Route::get('/destinations/{slug}', [PageController::class, 'destination'])->name('destinations.show');

    // Booking wizard --------------------------------------------------------
    Route::prefix('book')->name('booking.')->group(function (): void {
        Route::get('/{slug}', [BookingWizardController::class, 'start'])->name('start');
        Route::post('/quote', [BookingWizardController::class, 'quote'])->name('quote')->middleware('throttle:60,1');
        Route::post('/', [BookingWizardController::class, 'store'])->name('store')->middleware('throttle:10,1');
    });

    // Checkout --------------------------------------------------------------
    Route::prefix('checkout')->name('checkout.')->group(function (): void {
        Route::get('/{booking}/pay', [CheckoutController::class, 'pay'])->name('pay');
        Route::get('/{booking}/success', [CheckoutController::class, 'success'])->name('success');
        Route::get('/{booking}/cancel', [CheckoutController::class, 'cancel'])->name('cancel');
    });

    Route::post('/booking-lookup', [CheckoutController::class, 'lookup'])->name('booking.lookup')->middleware('throttle:10,1');

    // Content ---------------------------------------------------------------
    Route::get('/blog', [BlogController::class, 'index'])->defaults('type', 'blog')->name('blog.index');
    Route::get('/news', [BlogController::class, 'index'])->defaults('type', 'news')->name('news.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/faqs', [PageController::class, 'faqs'])->name('faqs');
    Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit')->middleware('throttle:5,1');
    Route::post('/subscribe', [PageController::class, 'subscribe'])->name('subscribe')->middleware('throttle:5,1');

    Route::middleware(['auth'])->group(function (): void {
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    });

    // CMS pages resolve last so they never shadow a real route.
    Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');
});

// Localisation --------------------------------------------------------------
Route::get('/locale/{code}', function (string $code) {
    abort_unless(
        \App\Models\Language::where('code', $code)->where('is_active', true)->exists(),
        404
    );

    session(['locale' => $code]);

    if ($user = auth()->user()) {
        $user->forceFill(['locale' => $code])->save();
    }

    return back();
})->name('locale.switch')->middleware('web');

Route::get('/currency/{code}', function (string $code) {
    abort_unless(app(\App\Services\CurrencyService::class)->switchTo($code), 404);

    return back();
})->name('currency.switch')->middleware('web');

// SEO -----------------------------------------------------------------------
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

// Gateway webhooks: CSRF-exempt, signature-verified.
Route::post('/webhooks/{gateway}', [WebhookController::class, 'handle'])
    ->middleware('webhook.source:{gateway}')
    ->name('webhooks.handle');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/customer.php';
