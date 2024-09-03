<?php

namespace App\Repositories\TrainingPlan;

interface ReadyTrainingPlanRepositoryInterface
{
    public function create(array $data);
    public function all();
}
