<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Losowo przypisany użytkownik
            'message' => $this->faker->sentence,
            'read' => $this->faker->boolean, // Losowy status przeczytania
        ];
    }
}
