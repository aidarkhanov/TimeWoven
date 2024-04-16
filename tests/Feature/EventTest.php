<?php

use App\Models\Event;
use App\Models\User;

it('allows authenticated users to create an event', function () {
    $user = User::factory()->create();
    $eventData = [
        'user_id' => $user->id,
        'title' => 'Sample Event',
        'description' => 'This is a sample description.',
        'start_time' => now()->addDays(1),
        'end_time' => now()->addDays(2),
        'external_link' => 'https://example.com',
        'organiser_email' => 'organiser@example.com',
    ];

    $this->actingAs($user)
        ->post('/events', $eventData)
        ->assertStatus(302)
        ->assertSessionHas('success', 'Event created successfully.')
        ->assertRedirect('/events');
});

it('prevents unauthorized users from updating an event', function () {
    $owner = User::factory()->create();
    $event = Event::factory()->create(['user_id' => $owner->id]);
    $otherUser = User::factory()->create();

    $this->actingAs($otherUser)
        ->patch("/events/{$event->id}", ['title' => 'Unauthorized request.'])
        ->assertStatus(403);
});
