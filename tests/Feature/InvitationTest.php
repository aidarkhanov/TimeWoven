<?php

use App\Models\Event;
use App\Models\Invitation;

use function Pest\Laravel\post;

it('handles an invitation response correctly', function () {
    $event = Event::factory()->create();
    $invitation = Invitation::factory()->create(['event_id' => $event->id]);

    $responseUrl = "/invitations/respond/{$invitation->token}";
    post($responseUrl, ['response' => 'accepted'])
        ->assertOk();

    expect($invitation->fresh()->response)->toBe('accepted');
});
