<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // ¡Importante añadir Hash para la contraseña!

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Creamos TU usuario Administrador principal.
        //    Esto asegura que siempre tengas una cuenta de admin después de sembrar.
        User::create([
            'name' => 'Ruben Condori',      // O el nombre que prefieras
            'email' => 'admin@canoto.com', // Un email fácil de recordar para ti
            'password' => Hash::make('password'), // La contraseña será "password"
            'role' => 'admin',
            'email_verified_at' => now(),  // Verificamos el email inmediatamente
        ]);

        // 2. Llamamos a nuestros otros seeders para poblar el resto de los datos.
        $this->call([
            UserSeeder::class,    // Este seeder creará los cajeros.
            ClienteSeeder::class, // Este seeder creará los clientes con sus cuentas de usuario.
        ]);
    }
}