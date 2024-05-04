@component('mail::message')
    # Invitation to {{ $title }}

    You are invited to attend the event **{{ $title }}**. We are excited for the opportunity to have you with us!

    **Event Details:**
    {{ $description }}

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
        ### Create Your Account
        If you do not have an account, please start by creating one. After registering, you can respond to the invitation directly through the options provided below.

        @component('mail::button', ['url' => route('register')])
            Create Account
        @endcomponent

        ### Respond to Invitation
    @else
        ### Respond to Invitation
    @endif

    @component('mail::button', ['url' => $response . '?response=accepted'])
        Accept
    @endcomponent

    @component('mail::button', ['url' => $response . '?response=declined'])
        Decline
    @endcomponent

    @component('mail::button', ['url' => $response . '?response=maybe'])
        Maybe
    @endcomponent

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
        **Note:** Please ensure you have completed your account setup before responding to the invitation.
    @endif

    If you did not expect to receive this invitation or if it was sent to you in error, please disregard this email.

    Thank you for your attention.

@endcomponent
