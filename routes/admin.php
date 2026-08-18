<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HomeFeatureController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TourDepartureController;
use App\Http\Controllers\Admin\WidgetController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TourCategoryController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'staff'])
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');

        // Tours -------------------------------------------------------------
        Route::post('tours/bulk', [TourController::class, 'bulk'])->name('tours.bulk');
        Route::post('tours/{tour}/duplicate', [TourController::class, 'duplicate'])->name('tours.duplicate');
        Route::patch('tours/{tour}/toggle', [TourController::class, 'toggle'])->name('tours.toggle');
        Route::resource('tours', TourController::class)->except('show');

        // Bookings ----------------------------------------------------------
        Route::prefix('bookings')->name('bookings.')->group(function (): void {
            Route::patch('{booking}/confirm', [BookingController::class, 'confirm'])->name('confirm');
            Route::patch('{booking}/complete', [BookingController::class, 'complete'])->name('complete');
            Route::patch('{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
            Route::post('{booking}/payments', [BookingController::class, 'recordPayment'])->name('payments.store');
            Route::patch('{booking}/note', [BookingController::class, 'updateNote'])->name('note');
        });
        Route::resource('bookings', BookingController::class)->except(['edit', 'update']);

        // Payments ----------------------------------------------------------
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::get('payments/{payment}/logs', [PaymentController::class, 'logs'])->name('payments.logs');
        Route::post('payments/{payment}/refund', [PaymentController::class, 'refund'])->name('payments.refund');

        // Catalogue (shared AJAX CRUD) --------------------------------------
        foreach ([
            'categories'      => TourCategoryController::class,
            'destinations'    => DestinationController::class,
            'coupons'         => CouponController::class,
            'testimonials'    => TestimonialController::class,
            'faqs'            => FaqController::class,
            'banners'         => BannerController::class,
            'post-categories' => PostCategoryController::class,
            'tags'            => TagController::class,
            'countries'       => CountryController::class,
            'cities'          => CityController::class,
            'currencies'      => CurrencyController::class,
            'languages'       => LanguageController::class,
            'home-features'   => HomeFeatureController::class,
        ] as $slug => $controller) {
            Route::prefix($slug)->name("{$slug}.")->group(function () use ($controller): void {
                Route::get('/', [$controller, 'index'])->name('index');
                Route::post('/', [$controller, 'store'])->name('store');
                Route::put('{id}', [$controller, 'update'])->name('update');
                Route::delete('{id}', [$controller, 'destroy'])->name('destroy');
                Route::post('bulk', [$controller, 'bulk'])->name('bulk');
            });
        }

        // Reviews -----------------------------------------------------------
        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
        Route::patch('reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
        Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        // CMS ---------------------------------------------------------------
        Route::resource('pages', PageController::class)->except('show');

        // Users -------------------------------------------------------------
        Route::resource('users', UserController::class)->except(['create', 'edit']);

        // Reports -----------------------------------------------------------
        Route::get('reports/download', [ReportController::class, 'download'])->name('reports.download');
        Route::get('reports/{type}', [ReportController::class, 'show'])->name('reports.show');
        Route::get('reports/{type}/export/{format}', [ReportController::class, 'export'])->name('reports.export');

        // Settings ----------------------------------------------------------
        Route::get('settings/{group?}', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings/{group}', [SettingController::class, 'update'])->name('settings.update');

        // Departures (inventory) --------------------------------------------
        Route::prefix('tours/{tour}/departures')->name('departures.')->group(function (): void {
            Route::get('/', [TourDepartureController::class, 'index'])->name('index');
            Route::post('/', [TourDepartureController::class, 'store'])->name('store');
            Route::post('generate', [TourDepartureController::class, 'generate'])->name('generate');
        });
        Route::put('departures/{departure}', [TourDepartureController::class, 'update'])->name('departures.update');
        Route::delete('departures/{departure}', [TourDepartureController::class, 'destroy'])->name('departures.destroy');

        // Flash sales -------------------------------------------------------
        Route::get('flash-sales', [FlashSaleController::class, 'index'])->name('flash-sales.index');
        Route::post('flash-sales', [FlashSaleController::class, 'store'])->name('flash-sales.store');
        Route::put('flash-sales/{sale}', [FlashSaleController::class, 'update'])->name('flash-sales.update');
        Route::delete('flash-sales/{sale}', [FlashSaleController::class, 'destroy'])->name('flash-sales.destroy');

        // Blog --------------------------------------------------------------
        Route::resource('posts', PostController::class)->except('show');

        // Menus & widgets ---------------------------------------------------
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::post('menus/{menu}/items', [MenuController::class, 'storeItem'])->name('menus.items.store');
        Route::post('menus/{menu}/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
        Route::put('menu-items/{item}', [MenuController::class, 'updateItem'])->name('menus.items.update');
        Route::delete('menu-items/{item}', [MenuController::class, 'destroyItem'])->name('menus.items.destroy');

        Route::get('widgets', [WidgetController::class, 'index'])->name('widgets.index');
        Route::put('widgets/{widget}', [WidgetController::class, 'update'])->name('widgets.update');

        // Galleries ---------------------------------------------------------
        Route::get('galleries', [GalleryController::class, 'index'])->name('galleries.index');
        Route::post('galleries', [GalleryController::class, 'store'])->name('galleries.store');
        Route::get('galleries/{gallery}', [GalleryController::class, 'show'])->name('galleries.show');
        Route::post('galleries/{gallery}/images', [GalleryController::class, 'upload'])->name('galleries.upload');
        Route::delete('galleries/{gallery}/images/{image}', [GalleryController::class, 'destroyImage'])->name('galleries.images.destroy');
        Route::delete('galleries/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

        // Inbox -------------------------------------------------------------
        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::post('messages/{message}/reply', [ContactMessageController::class, 'reply'])->name('messages.reply');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
        Route::delete('subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');

        // Support tickets ---------------------------------------------------
        Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::post('tickets/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
        Route::patch('tickets/{ticket}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
        Route::patch('tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');

        // Invoices ----------------------------------------------------------
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
        Route::post('invoices/{invoice}/regenerate', [InvoiceController::class, 'regenerate'])->name('invoices.regenerate');

        // Roles & permissions (super admin only) -----------------------------
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

        // Notifications -----------------------------------------------------
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
        Route::post('notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    });
