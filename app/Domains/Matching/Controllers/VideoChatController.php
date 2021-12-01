<?php

namespace App\Domains\Matching\Controllers;

use App\Domains\Channel\Models\Channel;
use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoChatController extends Controller
{
    public function video(Channel $channel) {
        return Inertia::render('Video/Index', ['channelId'=>$channel->id]);
    }
    public function chat(Channel $channel) {
        $channel->members();
        return Inertia::render('Chat/Index', ['channel' => $channel]);
    }
}
