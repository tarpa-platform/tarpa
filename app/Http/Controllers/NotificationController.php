<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->linkable->notifications;

        $notifications = $notifications->map(function ($notification) {
            $ntype = app($notification->type);
            $notification['display_name'] = $ntype->display_name();
            $notification['display_description'] = $ntype->display_description();
            $notification['display_model_key'] = $ntype->display_model_key();
            $notification['display_data_key'] = $ntype->display_data_key();
            $notification['model_route_name'] = $ntype->model_route_name();
            return $notification;
        });

        return Inertia::render('Notification/Index', ['notifications' => $notifications]);
    }

    public function unread(Request $request)
    {
        return $request->user()->linkable->unreadNotifications->count();
    }

    public function mark_read(Request $request)
    {
        $request->user()->linkable->unreadNotifications->markAsRead();

        return response(null, 204);
    }
}
