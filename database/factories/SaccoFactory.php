<?php

namespace Database\Factories;

use App\Models\Sacco;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sacco>
 */
class SaccoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->name(),
            'deactivated_at' => $this->faker->boolean() ? now() : null
        ];
    }
}
