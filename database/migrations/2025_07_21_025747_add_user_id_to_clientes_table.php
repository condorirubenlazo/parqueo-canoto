<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Creamos la columna para el ID del usuario.
            // Debe ser nullable() porque los clientes antiguos o los visitantes no tendrán una cuenta de usuario.
            // La ponemos después de la columna 'id' por orden.
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Esto es para poder deshacer la migración si es necesario.
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};