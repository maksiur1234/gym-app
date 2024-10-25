<?php

namespace App\Repositories\Workout;

interface WorkoutSessionRepositoryInterface
{
    public function create(array $data);

    public function find($id);

    public function getLastSessionId();
}
