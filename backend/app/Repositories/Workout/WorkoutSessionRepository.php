<?php

namespace App\Repositories\Workout;

use App\Models\Workout\WorkoutSession;
use App\Repositories\Workout\WorkoutSessionRepositoryInterface;

class WorkoutSessionRepository implements WorkoutSessionRepositoryInterface
{
    public function create(array $data)
    {
        return WorkoutSession::create($data);
    }

    public function find($id)
    {
        return WorkoutSession::find($id);
    }

    public function getLastSessionId()
    {
        $lastSession = WorkoutSession::orderBy('session_id', 'desc')->first();
        return $lastSession ? $lastSession->session_id + 1 : 1;
    }
}
