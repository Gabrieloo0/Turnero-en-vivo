<?php

namespace App\Http\Controllers;

use App\Events\SolicitudPosted;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use App\Jobs\CambiarEstadoTurno;

class TurnoController extends Controller
{
    /**
     * Vista del emisor: formulario para pedir turno
     */
    public function index()
    {
        return view('solicitud'); // solo muestra el formulario
    }

    /**
     * Vista de la pantalla de clientes: últimos turnos en tiempo real
     */
    public function pantalla()
    {
        $solicitudes = Solicitud::latest()->take(10)->get();
        return view('pantalla', compact('solicitudes'));
    }

    /**
     * Guardar nueva solicitud y emitir evento
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user'    => 'nullable|string|max:100',
            'dni'     => 'nullable|string|max:20',
            'content' => 'required|string|max:255',
            'tipo'    => 'required|in:CAJA,AT',
        ]);

        // ✅ Generar número de turno según tipo
        $ultimo = Solicitud::where('tipo', $data['tipo'])->count() + 1;
        $numero = ($data['tipo'] === 'CAJA' ? 'C' : 'A') . str_pad($ultimo, 3, '0', STR_PAD_LEFT);

        // ✅ Crear solicitud con número asignado
        $solicitud = Solicitud::create([
            'user'    => $data['user'] ?? 'Anon',
            'dni'     => $data['dni'] ?? null,
            'content' => $data['content'],
            'tipo'    => $data['tipo'],
            'numero'  => $numero,
            'estado'  => 'pendiente',
        ]);

        // ✅ Refrescar el modelo antes de emitir el evento
        $solicitud = $solicitud->fresh();

        // Emitir evento broadcast inicial
        event(new SolicitudPosted($solicitud));

        // Automatización con colas: cambiar estado en segundo plano
        // A los 10 segundos pasa a "en_atencion"
        CambiarEstadoTurno::dispatch($solicitud, 'en_atencion')->delay(now()->addSeconds(10));

        // A los 30 segundos pasa a "finalizado"
        CambiarEstadoTurno::dispatch($solicitud, 'finalizado')->delay(now()->addSeconds(30));

        // Si usás AJAX, devolver JSON
        if ($request->ajax()) {
            return response()->json(['ok' => true, 'solicitud' => $solicitud]);
        }

        // Si usás formulario clásico, redirigir con mensaje
        return redirect()->route('solicitud.index')
                         ->with('success', "Tu turno es {$numero}");
    }
}