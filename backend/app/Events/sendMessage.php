<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class sendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message ;
    public  $userId ;
    public  $conversationId ;
    /**
     * Create a new event instance.
     */
    public function __construct($message,$userId,$conversationId)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->conversationId = $conversationId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('private.' . $this->conversationId),
        ];
    }
    public function broadcastAs()
    {
        return 'chat';
    }
    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'userId' => $this->userId,
            'conversationId' => $this->conversationId,
        ];
    }
}
