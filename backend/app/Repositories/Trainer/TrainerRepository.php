<?php

namespace App\Repositories\Trainer;

use App\Models\User\User;
use App\Repositories\Trainer\TrainerRepositoryInterface;

class TrainerRepository implements TrainerRepositoryInterface
{
    public function all(int $page)
    {
        return User::where('role_id', 1)->paginate($page); //role_id 1 is trainer
    }
}
