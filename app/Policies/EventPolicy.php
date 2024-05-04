<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        if ($user->id === $event->user_id) {
            return true;
        }

        return Invitation::where('event_id', $event->id)
            ->where('email', $user->email)
            ->where('response', 'accepted')
            ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Assuming all authenticated users can create an event
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): bool
    {
        // Assuming only users who can delete can also restore the event
        // This often aligns with soft delete capabilities
        return $this->delete($user, $event);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): bool
    {
        // Assuming only admins or specific roles can permanently delete events
        // Example of admin check, adjust according to your application's role management
        return $user->is_admin;
    }
}
