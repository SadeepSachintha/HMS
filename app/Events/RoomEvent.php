<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room;
    public $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Room $room, string $action)
    {
        $this->room = $room;
        $this->action = $action; // 'created', 'updated', or 'deleted'
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('rooms');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'room' => [
                'id' => $this->room->id,
                'number' => $this->room->number,
                'type' => $this->room->roomType->name ?? 'N/A',
                'floor' => $this->room->floor,
                'notes' => $this->room->notes ?? 'No description available'
            ],
            'action' => $this->action
        ];
    }
}
