<?php

namespace App\Http\Controllers;

use App\Domains\Channel\Models\Channel;
use App\Domains\User\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoChatController extends Controller
{
    public function index(Channel $channel) {
        return Inertia::render('Video/Index', ['channelId'=>$channel->id]);
    }
}
