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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); // ID único para cada cliente (Llave primaria)
            $table->string('nombre'); // Nombre del cliente
            $table->string('apellido'); // Apellido del cliente
            $table->string('ci')->unique(); // Cédula de Identidad, debe ser única
            $table->string('telefono')->nullable(); // Teléfono del cliente (opcional)
            
            // Tipo de cliente: 'visitante', 'abonado', o 'abonado_vip'. Por defecto es 'visitante'
            $table->enum('tipo', ['visitante', 'abonado', 'abonado_vip'])->default('visitante');
            
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
        Schema::dropIfExists('clientes');
    }
};