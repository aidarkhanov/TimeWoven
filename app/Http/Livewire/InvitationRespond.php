<?php

namespace App\Http\Livewire;

use App\Models\Invitation;
use Illuminate\View\View;
use Livewire\Component;

class InvitationRespond extends Component
{
    public Invitation $invitation;

    public function mount(string $token): void
    {
        $this->invitation = Invitation::where('token', $token)->firstOrFail();
    }

    public function respond(string $response): void
    {
        if (! in_array($response, ['pending', 'accepted', 'declined', 'maybe'])) {
            abort(400, 'Invalid response.');
        }

        $this->invitation->update(['response' => $response]);
        session()->flash('message', 'Your response has been recorded.');
    }

    public function render(): View
    {
        return view('livewire.invitation-respond');
    }
}
