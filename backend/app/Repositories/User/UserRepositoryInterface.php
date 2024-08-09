<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function all(int $page);
    public function find(int $id);
    public function update(int $id, $data);
}
