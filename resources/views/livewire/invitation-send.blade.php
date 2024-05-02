<div>
    <input type="email" wire:model="email" placeholder="Enter email to invite">
    <button wire:click="send">Send Invitation</button>
    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif
</div>
