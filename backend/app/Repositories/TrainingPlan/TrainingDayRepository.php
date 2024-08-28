<?php
namespace App\Repositories\TrainingPlan;

use App\Models\TrainingPlan\TrainingDay;

class TrainingDayRepository implements TrainingDayRepositoryInterface
{
    public function create(array $data)
    {
        return TrainingDay::create($data);
    }
}
