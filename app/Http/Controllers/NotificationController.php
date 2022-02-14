<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications');
    }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        Toastr::success('All Notifications marked as read', 'Success');
        return redirect()->back();
    }

    public function destroy()
    {
        auth()->user()->notifications()->delete();
        Toastr::success('All caught up!', 'Success');
        return redirect()->back();
    }
}
