<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id(); // ID único del vehículo
            
            // Relación con la tabla 'clientes'. Si se borra un cliente, se borran sus vehículos.
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            
            $table->string('placa')->unique(); // Placa del vehículo, debe ser única
            $table->string('marca'); // Marca del vehículo (ej. Toyota)
            $table->string('modelo'); // Modelo del vehículo (ej. Corolla)
            $table->string('color'); // Color del vehículo
            
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
};