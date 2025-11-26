<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TurnoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí definís las rutas web de tu aplicación. Estas rutas son cargadas
| por el RouteServiceProvider dentro de un grupo que contiene el middleware "web".
|
*/
Route::get('/', function () {
    return redirect()->route('solicitud.index');
});
// Ruta raíz: formulario de solicitud de turnos (emisor)
Route::get('/solicitud', [TurnoController::class, 'index'])
    ->name('solicitud.index');

// Ruta para guardar nueva solicitud (POST desde el formulario)
Route::post('/solicitud_store', [TurnoController::class, 'store'])
    ->name('solicitud.store');

// Ruta para la pantalla de clientes (display en tiempo real)
Route::get('/pantalla', [TurnoController::class, 'pantalla'])
    ->name('solicitud.pantalla');