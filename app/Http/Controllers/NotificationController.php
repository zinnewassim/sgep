<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function readAll()
    {
        Auth::user()->unreadNotifications()->update(['lu' => true]);
        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}
