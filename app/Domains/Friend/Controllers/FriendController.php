<?php

namespace App\Domains\Friend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FriendController extends Controller
{
    public function index()
    {
        $friends = $this->getFriendList();
        return Inertia::render('Friend/Friend', ["friends"=>$friends]);
    }
    public function getFriendList()
    {
        $user = Auth::user()->getFriendsAttribute();
        return $user;
    }
}
