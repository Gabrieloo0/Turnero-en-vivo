<?php

namespace App\Events;

use App\Models\Solicitud;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SolicitudPosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Solicitud $solicitud;

    /**
     * Crear nueva instancia del evento.
     */
    public function __construct(Solicitud $solicitud)
    {
        // Aseguramos que el modelo esté fresco desde la base de datos
        $this->solicitud = $solicitud->fresh();
    }

    /**
     * Canal de broadcast.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('turnos');
    }

    /**
     * Nombre del evento en el frontend.
     */
    public function broadcastAs(): string
    {
        return 'SolicitudPosted';
    }

    /**
     * Datos enviados al frontend.
     */
    public function broadcastWith(): array
    {
        return [
            'id'         => $this->solicitud->id,
            'user'       => $this->solicitud->user,
            'dni'        => $this->solicitud->dni,
            'content'    => $this->solicitud->content,
            'tipo'       => $this->solicitud->tipo,
            'numero'     => $this->solicitud->numero ?? 'SIN NUMERO', // ✅ fallback si viene null
            'estado'     => $this->solicitud->estado,
            'puesto'     => $this->solicitud->puesto ?? null,
            'created_at' => optional($this->solicitud->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}