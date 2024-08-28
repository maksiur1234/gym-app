<?php

namespace App\Repositories\Schedule;

use App\Models\Schedule\TrainingSchedule;

class TrainingScheduleRepository
{
    public function create(array $data)
    {
        return TrainingSchedule::create($data);
    }

    public function getSchedulesForUser($userId)
    {
        return TrainingSchedule::where('user_id', $userId)->with('trainingPlan')->get();
    }

    public function delete($id)
    {
        return TrainingSchedule::destroy($id);
    }
}
