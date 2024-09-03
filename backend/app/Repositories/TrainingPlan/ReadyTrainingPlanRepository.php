<?php

namespace App\Repositories\TrainingPlan;

use App\Models\TrainingPlan\ReadyTrainingPlan;
use App\Repositories\TrainingPlan\ReadyTrainingPlanRepositoryInterface;

class ReadyTrainingPlanRepository implements ReadyTrainingPlanRepositoryInterface
{

    public function create(array $data)
    {
        return ReadyTrainingPlan::create($data);
    }

    public function all()
    {
        return ReadyTrainingPlan::all();
    }
}
