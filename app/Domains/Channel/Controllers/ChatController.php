<?php

namespace App\Domains\Channel\Controllers;

use App\Domains\Channel\Events\ChatMessage;
use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Models\Chat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function store(Request $request, Channel $channel)
    {
        broadcast(new ChatMessage($channel->id, $request->message));
        $chat = Chat::where('member_id', Auth::id())
            ->where('channel_id', $channel->id)
            ->with('member')->get();

        return response()->json($chat, 201);
    }
}
