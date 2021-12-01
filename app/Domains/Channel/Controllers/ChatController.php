<?php

namespace App\Domains\Channel\Controllers;

use App\Domains\Channel\Events\ChatMessage;
use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Models\Chat;
use App\Http\Controllers\Controller;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function store(Channel $channel)
    {
        $chat = Chat::create([
            'content' => request('message'),
            'member_id' => Auth::id(),
            'channel_id' => $channel->id,
        ]);
        $chat->load('member');

        broadcast(new ChatMessage($channel->id, $chat));
//        event(new ChatMessage($channel->id, $chat));

        return response()->json(["message" => "success"], 201);
    }
}
