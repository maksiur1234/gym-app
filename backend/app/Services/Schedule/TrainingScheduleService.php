<?php

namespace App\Services\Schedule;

use App\Repositories\Schedule\TrainingScheduleRepositoryInterface;

class TrainingScheduleService
{
    protected $trainingScheduleRepository;

    public function __construct(TrainingScheduleRepositoryInterface $trainingScheduleRepository)
    {
        $this->trainingScheduleRepository = $trainingScheduleRepository;
    }

    public function addToSchedule($userId, $trainingDayId, $scheduledDate)
    {
        $existingSchedule = $this->trainingScheduleRepository->getTrainingSchedulesForUser($userId)
            ->where('training_day_id', $trainingDayId)
            ->where('scheduled_date', $scheduledDate)
            ->first();

        if ($existingSchedule) {
            throw new \Exception('This day is scheduled.');
        }

        return $this->trainingScheduleRepository->addTrainingDayToSchedule($userId, $trainingDayId, $scheduledDate);
    }
}
