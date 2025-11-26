<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->string('user');                                // nombre del solicitante
            $table->string('dni')->nullable();                     // DNI opcional
            $table->string('content');                             // motivo del turno
            $table->enum('tipo', ['CAJA', 'AT'])->default('AT');   // tipo de atención
            $table->string('numero')->nullable();                  // número de turno (C001, A014, etc.)
            $table->enum('estado', ['pendiente', 'en_atencion', 'finalizado'])->default('pendiente');
            $table->string('puesto')->nullable();                  // caja/box asignado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};