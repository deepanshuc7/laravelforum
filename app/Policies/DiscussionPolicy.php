<?php

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionPolicy
{
    use HandlesAuthorization;

    
    public function update(User $user, Discussion $discussion)
    {
        return $user->id === $discussion->user_id;
    }

   
    public function delete(User $user, Discussion $discussion)
    {
        // return $user->id === $discussion->user_id;
        return $user->is_admin || $user->id === $discussion->user_id;
    }
}
