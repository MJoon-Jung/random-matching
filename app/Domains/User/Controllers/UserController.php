<?php

namespace App\Domains\User\Controllers;

use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function searchUser(Request $request)
    {
        $name = $request?->query('name');

        $users = User::where('name', 'like', $name.'%')->get();
        return $users;
    }
    public function getNotification()
    {
        $notifications = Auth::user()->notifications;
        $unreadNotificationsCount = Auth::user()->unreadNotifications->count();
        return response()->json(["notifications"=>$notifications, 'unreadNotificationsCount'=>$unreadNotificationsCount]);
    }
}
