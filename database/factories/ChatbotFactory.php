<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatbotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'error']),
            'user_id' => User::factory(),
        ];
    }
} 