<?php

namespace App\Domains\Friend\Controllers;

use App\Domains\Friend\Models\Friend;
use App\Domains\Friend\Notifications\Friendship;
use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class FriendController extends Controller
{
    public function index()
    {
        $friends = $this->getFriendList();
        return Inertia::render('Friend/Friend', ['friends' => $friends]);
    }

    public function store(int $id)
    {
    }

    public function getFriendList()
    {
        $user = Auth::user()->getFriendsAttribute();
        return $user;
    }

    public function request(User $user)
    {
        Notification::send($user, new Friendship(Auth::user()));
    }

    public function receive(User $user)
    {
        $friend = Friend::create([
            'user_id' => $user->id,
            'friend_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'success']);
    }
}
