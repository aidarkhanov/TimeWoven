<?php

namespace Tests\Unit;

use App\Http\Livewire\InvitationRespond;
use App\Models\Invitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InvitationRespondTest extends TestCase
{
    use RefreshDatabase;

    public function test_updates_invitation_response_correctly()
    {
        $invitation = Invitation::factory()->create(['response' => 'pending']);

        Livewire::test(InvitationRespond::class, ['token' => $invitation->token])
            ->call('respond', 'declined')
            ->assertHasNoErrors();

        $this->assertEquals('declined', $invitation->fresh()->response);
    }
}
