<?php

namespace Tests\Unit;

use App\Http\Livewire\EventForm;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EventFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_initializes_correctly_from_existing_event()
    {
        $event = Event::factory()->create();

        Livewire::test(EventForm::class, ['event_id' => $event->id])
            ->assertSet('title', $event->title)
            ->assertSet('description', $event->description);
    }

    public function test_validates_input_before_saving()
    {
        Livewire::test(EventForm::class)
            ->set('title', '')
            ->call('saveEvent')
            ->assertHasErrors(['title' => 'required']);
    }
}
