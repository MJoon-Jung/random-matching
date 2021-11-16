<?php

namespace App\Domains\Channel\Listeners;

use App\Domains\Channel\Events\NewChannelEvent;
use App\Domains\Matching\Models\Matching;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NewChannelNotification
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
     * @param  \App\Domains\Channel\Events\NewChannelEvent  $event
     * @return void
     */
    public function handle(NewChannelEvent $event)
    {
        Matching::create([
            'type' => $event->getType(),
            'man_id' => $event->getManId(),
            'woman_id' => $event->getWomanId(),
        ]);

        Log::info(get_class($event) . ' 이벤트를 수신');
        Log::info(
            sprintf(
                "%s 채널[%s]에서 %d 님과 %d 님이 매칭을 시작합니다",
//                "%s %s님이 %d 채널에 (%s) 메세지를 보냈습니다.",
                $event->getChannelId(),
                $event->getType(),
                $event->getManId(),
                $event->getWomanId(),
            )
        );
    }
}
