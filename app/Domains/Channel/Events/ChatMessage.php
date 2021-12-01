<?php

namespace App\Domains\Channel\Events;

use App\Domains\Channel\Models\Chat;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(private string $channelId, private Chat $chat){
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('channel.' . $this->channelId);
    }
    public function broadcastAs()
    {
        return 'new.message';
    }
    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['chat'=>$this->chat];
    }

    public function getChannelId()
    {
        return $this->channelId;
    }
    public function getContent()
    {
        return $this->chat->content;
    }
}
