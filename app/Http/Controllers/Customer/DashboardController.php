<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return view('customer.dashboard', [
            'stats' => [
                'bookings'  => $user->bookings()->count(),
                'upcoming'  => $user->bookings()->upcoming()->count(),
                'completed' => $user->bookings()->where('status', BookingStatus::Completed->value)->count(),
                'spent'     => (float) $user->bookings()->revenueCounted()->sum('paid_amount'),
                'due'       => (float) $user->bookings()->revenueCounted()->sum('due_amount'),
                'wishlist'  => $user->wishlists()->count(),
            ],
            'upcoming'      => $user->bookings()->upcoming()->with('tour:id,title,slug,thumbnail')->orderBy('travel_date')->limit(3)->get(),
            'recent'        => $user->bookings()->with('tour:id,title,slug,thumbnail')->latest('id')->limit(5)->get(),
            'notifications' => $user->unreadNotifications()->limit(5)->get(),
        ]);
    }
}
