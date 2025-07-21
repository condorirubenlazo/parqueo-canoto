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
        Schema::create('registros_parqueo', function (Blueprint $table) {
            $table->id();
            $table->string('placa');
            $table->dateTime('fecha_hora_ingreso');
            $table->dateTime('fecha_hora_salida')->nullable();
            $table->decimal('monto_cobrado', 8, 2)->nullable();
            $table->string('tipo_cliente');
            $table->string('espacio_asignado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros_parqueo');
    }
};