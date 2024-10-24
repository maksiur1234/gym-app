<?php

namespace App\Repositories\Trainer;

use App\Enums\Role;
use App\Models\User\User;
use App\Repositories\Trainer\TrainerRepositoryInterface;

class TrainerRepository implements TrainerRepositoryInterface
{
    public function all(int $page)
    {
        return User::where('role_id', Role::Trainer->value)->paginate($page); 
    }
}
