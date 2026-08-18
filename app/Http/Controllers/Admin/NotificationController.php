<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return $request->wantsJson()
            ? $this->ok([
                'unread' => $request->user()->unreadNotifications()->count(),
                'items'  => $request->user()->notifications()->limit(15)->get(),
            ])
            : view('admin.notifications', ['notifications' => $request->user()->notifications()->paginate(30)]);
    }

    public function markRead(Request $request, string $id)
    {
        $request->user()->notifications()->whereKey($id)->update(['read_at' => now()]);

        return $this->ok(message: 'Marked as read.');
    }

    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back();
    }
}
