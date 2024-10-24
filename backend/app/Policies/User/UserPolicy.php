<?php

namespace App\Policies\User;

use App\Enums\Role;
use App\Models\User\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */

    public function update(User $currentUser, User $user)
    {
        return $currentUser->role_id === Role::Admin->value;
    }
}
