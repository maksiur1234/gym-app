<?php

namespace App\Policies\User;

use App\Models\User\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */

    public function update(User $currentUser, User $user)
    {
        return $currentUser->role_id === 1;
    }
}
