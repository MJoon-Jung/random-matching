<?php

namespace App\Domains\Channel\Observers;

use App\Domains\Channel\Events\NewChannelEvent;
use App\Domains\Channel\Models\Channel;
use App\Domains\Channel\Models\Member;

class ChannelObserver
{
    /**
     * Handle the Channel "created" event.
     *
     * @param  \App\Domains\Channel\Models\Channel  $channel
     * @return void
     */
    public function created(Channel $channel)
    {
        $member = Member::where('channel_id', $channel->id)->first();
        broadcast(new NewChannelEvent($channel, $member->man_id, $member->woman_id));
    }
    /**
     * Handle the Channel "updated" event.
     *
     * @param  \App\Domains\Channel\Models\Channel  $channel
     * @return void
     */
    public function updated(Channel $channel)
    {
        //
    }
    /**
     * Handle the Channel "deleted" event.
     *
     * @param  \App\Domains\Channel\Models\Channel  $channel
     * @return void
     */
    public function deleted(Channel $channel)
    {
        //
    }

    /**
     * Handle the Channel "restored" event.
     *
     * @param  \App\Domains\Channel\Models\Channel  $channel
     * @return void
     */
    public function restored(Channel $channel)
    {
        //
    }

    /**
     * Handle the Channel "force deleted" event.
     *
     * @param  \App\Domains\Channel\Models\Channel  $channel
     * @return void
     */
    public function forceDeleted(Channel $channel)
    {
        //
    }
}
