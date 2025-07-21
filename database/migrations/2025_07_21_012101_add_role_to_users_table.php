<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Esto se ejecuta cuando corremos el comando 'php artisan migrate'.
     *
     * @return void
     */
    public function up()
    {
        // Le decimos a Laravel que queremos modificar la tabla 'users'.
        Schema::table('users', function (Blueprint $table) {
            
            // Añadimos la nueva columna llamada 'role'.
            // Será de tipo string (texto).
            $table->string('role')
                  ->after('name') // La colocamos justo después de la columna 'name' por orden.
                  ->default('cajero'); // ¡MUY IMPORTANTE! Por defecto, cualquier usuario nuevo será 'cajero'.
        });
    }

    /**
     * Reverse the migrations.
     * Esto se ejecutaría si quisiéramos deshacer la migración.
     *
     * @return void
     */
    public function down()
    {
        // Le decimos a Laravel que, si deshacemos, simplemente elimine la columna 'role'.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};