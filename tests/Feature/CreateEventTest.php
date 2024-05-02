<?php

namespace Tests\Feature;

use App\Http\Livewire\EventForm;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_event()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(EventForm::class)
            ->set('title', 'New Event')
            ->set('description', 'Description here')
            ->set('start_time', now()->addHours(3)->toDateTimeString())
            ->set('end_time', now()->addHours(5)->toDateTimeString())
            ->call('saveEvent')
            ->assertRedirect('/events');

        $this->assertTrue(Event::where('title', 'New Event')->exists());
    }

    public function test_event_times_are_valid()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(EventForm::class)
            ->set('start_time', now()->addDay())
            ->set('end_time', now()->addHours(3))
            ->call('saveEvent')
            ->assertHasErrors(['end_time' => 'after:start_time']);
    }
}
