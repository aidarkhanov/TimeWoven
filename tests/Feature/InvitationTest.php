<?php

namespace Tests\Feature;

use App\Http\Livewire\InvitationRespond;
use App\Http\Livewire\InvitationSend;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_invitation_can_be_sent()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(InvitationSend::class, ['event' => $event])
            ->set('email', 'test@example.com')
            ->call('send')
            ->assertHasNoErrors();

        $this->assertTrue(Invitation::where('email', 'test@example.com')->exists());
    }

    public function test_user_can_respond_to_invitation()
    {
        $invitation = Invitation::factory()->create();

        Livewire::test(InvitationRespond::class, ['token' => $invitation->token])
            ->call('respond', 'accepted')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('invitations', [
            'id' => $invitation->id,
            'response' => 'accepted',
        ]);
    }
}
