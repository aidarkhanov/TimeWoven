<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\CreateEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function show(Request $request)
    {
        return view('events.show');
    }

    public function create(Request $request)
    {
        return view('events.create');
    }

    public function store(CreateEventRequest $request)
    {
        Event::create($request->validated() + ['user_id' => auth()->id()]);

        return redirect()->route('events.show')->with('success', 'Event created successfully.');
    }

    public function edit(Request $request)
    {
        return view('events.edit');
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $event->update($request->validated());

        return redirect()->route('events.show')->with('success', 'Event updated successfully.');
    }

    public function destroy(Request $request, Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
