<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function read(string $id)
    {
        $notif = Auth::user()->notifications()->findOrFail($id);
        $notif->markAsRead();
        return redirect()->back();
    }

    public function readAll()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Todas marcadas como lidas.');
    }
}