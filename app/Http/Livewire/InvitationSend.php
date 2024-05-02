<?php

namespace App\Http\Livewire;

use App\Mail\InvitationMail;
use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InvitationSend extends Component
{
    public Event $event;

    #[Validate('required|email')]
    public string $email;

    public function mount(?Event $event = null): void
    {
        $this->event = $event ?? abort(404);
    }

    public function send(): void
    {
        $this->validate();

        $token = Str::random(16);
        $invitation = Invitation::create([
            'event_id' => $this->event->id,
            'email' => $this->email,
            'token' => $token,
        ]);

        Mail::to($this->email)->send(new InvitationMail($this->event, $invitation));
        session()->flash('message', 'Invitation sent successfully to '.$this->email);
    }

    public function render(): View
    {
        return view('livewire.invitation-send');
    }
}
