<?php

namespace App\Repositories\User;

use App\Models\User\User;

class UserRepository implements UserRepositoryInterface
{
    public function all(int $page)
    {
        return User::paginate($page);
    }

    public function find(int $id)
    {
        return User::find($id);
    }

    public function update(int $id, $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }
}
