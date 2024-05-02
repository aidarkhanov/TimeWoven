<div>
    <h3>Respond to Invitation: {{ $invitation->event->title }}</h3>
    <button wire:click="respond('accepted')">Accept</button>
    <button wire:click="respond('declined')">Decline</button>
    <button wire:click="respond('maybe')">Maybe</button>
    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>
