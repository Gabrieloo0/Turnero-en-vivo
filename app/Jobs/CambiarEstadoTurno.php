<?php

namespace App\Jobs;

use App\Models\Solicitud;
use App\Events\SolicitudPosted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CambiarEstadoTurno implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Solicitud $solicitud;
    protected string $estado;

    /**
     * Crear nueva instancia del Job.
     */
    public function __construct(Solicitud $solicitud, string $estado)
    {
        $this->solicitud = $solicitud;
        $this->estado = $estado;
    }

    /**
     * Ejecutar el Job.
     */
    public function handle(): void
    {
        // Buscar la solicitud actualizada desde la BD
        $solicitud = Solicitud::find($this->solicitud->id);

        if (!$solicitud) {
            return;
        }

        // Cambiar estado
        $solicitud->estado = $this->estado;

        // Si pasa a "en_atencion", asignar puesto automáticamente
        if ($this->estado === 'en_atencion') {
            if ($solicitud->tipo === 'CAJA') {
                $solicitud->puesto = 'Caja ' . rand(1, 4);
            } elseif ($solicitud->tipo === 'AT') {
                $solicitud->puesto = 'Box ' . rand(1, 3);
            }
        }

        // Guardar cambios
        $solicitud->save();

        // Emitir evento para actualizar pantalla en tiempo real
        event(new SolicitudPosted($solicitud));
    }
}