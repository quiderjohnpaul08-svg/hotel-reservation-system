<?php

namespace Database\Factories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->bothify(fake()->randomElement([
                'Standard Room Type ###',
                'Deluxe Room Type ###',
                'Family Suite Type ###',
                'Executive Suite Type ###',
                'Presidential Suite Type ###',
            ])),
            'description' => fake()->sentence(12),
        ];
    }
}
