<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Invitation>
 */
class InvitationFactory extends Factory
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
            'email' => $this->faker->email,
            'token' => Str::random(40),
            'response' => 'pending',
        ];
    }
}
