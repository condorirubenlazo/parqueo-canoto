<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // No ponemos user_id aquí, porque se lo daremos manualmente desde el seeder.
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'ci' => fake()->unique()->numerify('########'), // Genera un CI numérico único de 8 dígitos
            'telefono' => fake()->numerify('7#######'), // Genera un número de teléfono de 8 dígitos que empieza con 7
            'tipo' => fake()->randomElement(['abonado', 'abonado_vip']), // Asigna un tipo de abonado al azar
        ];
    }
}