<?php

namespace App\Repositories\TrainingPlan;

use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\UserTrainingPlan;
use Illuminate\Support\Facades\DB;

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
    public function getAssignedPlans($userId)
    {
        return DB::table('user_training_plans as utp')
        ->join('training_plans as tp', 'utp.training_plan_id', '=', 'tp.id')
        ->where('utp.user_id', $userId)
        ->select('utp.*', 'tp.*')
        ->get();
    }

    public function create(array $data)
    {
        return TrainingPlan::create($data);
    }
}
