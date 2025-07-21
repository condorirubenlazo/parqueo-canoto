<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creamos 3 usuarios con el rol de 'cajero' para tener datos de prueba.
        User::factory(3)->create([
            'role' => 'cajero',
        ]);
    }
}