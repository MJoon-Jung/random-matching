<?php

namespace App\Domains\Channel\Events;


use App\Domains\Channel\Models\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChannelEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     ** @param  \App\Domains\Channel\Models\Channel  $channel
     *  @return void
     */
    public function __construct(private Channel $channel, private int $manId, private int $womanId)
    {
        $channel->member();
//        $channel->member_id;
    }
    public function broadcastAs()
    {
        return 'new.channel';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('users.'.$this->manId),
            new PrivateChannel('users.'.$this->womanId),
        ];
    }
    public function broadcastWith()
    {
        return [
            'channelId' => $this->channel->id,
        ];
    }
    public function getChannelId(): string
    {
        return $this->channel->id;
    }
    public function getType(): string
    {
        return $this->channel->type;
    }
    public function getManId(): int
    {
        return $this->manId;
    }
    public function getWomanId(): int
    {
        return $this->womanId;
    }
}
