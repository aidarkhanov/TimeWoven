<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_time' => $this->faker->dateTimeBetween('+1 days', '+2 days'),
            'end_time' => $this->faker->dateTimeBetween('+3 days', '+4 days'),
            'external_link' => $this->faker->url,
            'organiser_email' => $this->faker->optional()->email,
        ];
    }
}
