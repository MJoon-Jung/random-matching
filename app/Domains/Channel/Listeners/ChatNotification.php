<?php

namespace App\Domains\Channel\Listeners;

use App\Domains\Channel\Events\ChatMessage;
use App\Domains\Channel\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ChatMessage  $event
     * @return void
     */
    public function handle(ChatMessage $event)
    {
        Chat::create([
            'content' => $event->getContent(),
            'member_id' => Auth::id(),
            'channel_id' => $event->getChannelId()
        ]);

        Log::info(get_class($event) . ' 이벤트를 수신');
        Log::info(
            sprintf(
                "%s님이 %d 채널에 (%s) 메세지를 보냈습니다.",
                Auth::user()->name,
                $event->getChannelId(),
                $event->getContent(),
            )
        );
    }
}
