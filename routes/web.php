<?php

use App\Http\Controllers\TurnoController;
use Illuminate\Support\Facades\Route;

Route::get('/',[TurnoController::class, 'index']) ->name('turno.index');
Route::post('/solicitud',[TurnoController::class, 'store']) ->name('turno.store');

