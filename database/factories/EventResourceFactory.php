<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventResource;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<EventResource>
 */
class EventResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'external_link' => $this->faker->url(),
            'organiser_email' => $this->faker->unique()->safeEmail(),
            'location' => $this->faker->city(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
