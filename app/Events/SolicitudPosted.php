<?php

namespace App\Events;

use App\Models\Solicitud;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SolicitudPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Solicitud $solicitud){}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('turno');
    }

    public function broadcastAs(): string
    {
        return 'solicitud.posted';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->solicitud->id,
            'user' => $this->solicitud->user,
            'content' => $this->solicitud->content,
            'created_at' => $this->solicitud->created_at->toDateTimeString(),
        ];
    }

}
