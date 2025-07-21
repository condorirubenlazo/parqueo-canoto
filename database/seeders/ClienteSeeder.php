<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;    // <-- Asegúrate de importar User
use App\Models\Cliente; // <-- Asegúrate de importar Cliente

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creamos 7 clientes de prueba que también son usuarios para tener datos suficientes.
        for ($i = 0; $i < 7; $i++) {
            
            // Paso 1: Creamos el registro en la tabla 'users' con el rol de 'cliente'.
            // La UserFactory se encarga de generar un nombre y email falsos.
            $user = User::factory()->create([
                'role' => 'cliente',
            ]);

            // Paso 2: Usamos la ClienteFactory para crear un perfil de cliente
            // y lo vinculamos con el usuario que acabamos de crear.
            Cliente::factory()->create([
                'user_id'  => $user->id,          // ¡La vinculación mágica ocurre aquí!
                'nombre'   => $user->name,        // Usamos el nombre del usuario para que los datos coincidan.
                'apellido' => fake()->lastName(), // Generamos un apellido falso para completar.
            ]);
        }
    }
}