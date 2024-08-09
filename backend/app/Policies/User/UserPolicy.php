<?php

namespace App\Policies\User;

use App\Models\User\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */

    public function update(User $user, User $model)
    {
        return $user->role_id === 1 || $user->id === $model->id;
    }
}
