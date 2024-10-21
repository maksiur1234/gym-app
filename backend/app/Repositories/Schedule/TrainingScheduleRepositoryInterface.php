<?php
namespace App\Repositories\Schedule;

interface TrainingScheduleRepositoryInterface
{
    public function addTrainingDayToSchedule($userId, $trainingDayId, $scheduledDate);
    public function getTrainingSchedulesForUser($userId);
}