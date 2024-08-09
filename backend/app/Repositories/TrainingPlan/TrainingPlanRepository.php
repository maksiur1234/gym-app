<?php

namespace App\Repositories\TrainingPlan;

use App\Models\TrainingPlan\TrainingPlan;

class TrainingPlanRepository implements TrainingPlanRepositoryInterface
{
    public function store(array $data)
    {
        return TrainingPlan::create($data);
    }

    public function find(int $id)
    {
        return TrainingPlan::find($id);
    }

    public function getAll(): array
    {
        return TrainingPlan::all()->toArray();
    }
    public function getByUserId($userId)
    {
        return TrainingPlan::where('user_id', $userId)->get();
    }
}
