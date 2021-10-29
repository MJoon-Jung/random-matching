<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function requestFriend()
    {
        $user = User::with('myFriends')->where('id', Auth::user()->id);
//        $user = User::with('getFriendsAttribute')->where('id', Auth::user()->id);
        return response()->json([$user]);

    }
}
