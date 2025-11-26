<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'user',
        'dni',
        'content',
        'tipo',
        'numero',
        'estado',
        'puesto',
    ];
}