<?php

namespace App\Domains\Channel\Controllers;

use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Models\Member;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChannelResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChannelController extends Controller
{
    public function index()
    {
        $friends = Auth::user()->getFriendsAttribute();

        return Inertia::render('Channel/Index',['friends' => $friends]);
    }

    public function show()
    {
    }
    public function loadChat(Channel $channel)
    {
        $channel->load('chats.member');

        return response()->json($channel);
    }
    public function participate(Channel $channel)
    {
        $channel->members()->save(new Member(['member_id'=>Auth::id(), 'channel_id'=>$channel->id]));

        $channel->load('members');

        return response()->json($channel);
    }

    public function store(Request $request)
    {
    }

    public function update()
    {
    }
}
