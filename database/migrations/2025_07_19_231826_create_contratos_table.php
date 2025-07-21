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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id(); // ID único del contrato
            
            // Relación con la tabla 'clientes'.
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            
            $table->date('fecha_inicio'); // Fecha en que inicia el abono
            $table->date('fecha_fin'); // Fecha en que vence el abono
            $table->decimal('monto', 8, 2); // Monto pagado por el abono (ej. 200.00 o 400.00)
            
            // Tipo de abono: 'abonado' o 'abonado_vip'
            $table->enum('tipo', ['abonado', 'abonado_vip']);
            
            // Indica si el contrato está actualmente activo o ya ha sido renovado/cancelado.
            $table->boolean('activo')->default(true);
            
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
        Schema::dropIfExists('contratos');
    }
};