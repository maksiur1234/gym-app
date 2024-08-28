<?php
namespace App\Services\Schedule;

use App\Repositories\Schedule\TrainingScheduleRepository;

class TrainingScheduleService
{
    protected $trainingScheduleRepo;

    public function __construct(TrainingScheduleRepository $trainingScheduleRepo)
    {
        $this->trainingScheduleRepo = $trainingScheduleRepo;
    }

    public function createSchedule($userId, $data)
    {
        $data['user_id'] = $userId;
        return $this->trainingScheduleRepo->create($data);
    }

    public function getSchedules($userId)
    {
        return $this->trainingScheduleRepo->getSchedulesForUser($userId);
    }

    public function deleteSchedule($id)
    {
        return $this->trainingScheduleRepo->delete($id);
    }
}
