<?php

namespace App\Repositories\Schedule;

use App\Models\Schedule\TrainingSchedule;
use Carbon\Carbon;

class TrainingScheduleRepository implements TrainingScheduleRepositoryInterface
{
    public function addTrainingDayToSchedule($userId, $trainingDayId, $scheduledDate)
    {
        return TrainingSchedule::create([
            'user_id' => $userId,
            'training_day_id' => $trainingDayId,
            'scheduled_date' => Carbon::parse($scheduledDate)->format('Y-m-d H:i:s'),
        ]);
    }

    public function getTrainingSchedulesForUser($userId)
    {
        return TrainingSchedule::where('user_id', $userId)->get();
    }
}
