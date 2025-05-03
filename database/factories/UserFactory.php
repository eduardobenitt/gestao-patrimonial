<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'status' => 'Ativo',
        ]);
    }

    public function tecnico(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'tecnico',
            'regime' => fake()->randomElement(['In Office', 'Hibrido']),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Inativo',
        ]);
    }

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = fake()->randomElement(['admin', 'tecnico', 'usuario']);

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('SenhaSegura123!'),
            'status' => fake()->randomElement(['Ativo', 'Inativo']),
            'role' => $role,
            'regime' => $role === 'admin'
                ? fake()->randomElement(['In Office', 'Hibrido'])
                : fake()->randomElement(['In Office', 'Home Office', 'Hibrido', 'Prestador']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
            'status' => 'Inativo',
        ]);
    }
}
