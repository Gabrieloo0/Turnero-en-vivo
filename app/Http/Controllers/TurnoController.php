<?php

namespace App\Http\Controllers;

use App\Events\SolicitudPosted;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
    {
        $solicitud = Solicitud::latest()->take(5)->get();
        return view('solicitud', compact('solicitud'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user' => 'nullable|string',
            'content' => 'required|string',
        ]);

        $solicitud = Solicitud::create([
            'user' => $data['user'] ?? 'Anon',
            'content' => $data['content'],
        ]);

        event(new SolicitudPosted($solicitud));

        return response()->json(['ok' => true]);
    }
}
