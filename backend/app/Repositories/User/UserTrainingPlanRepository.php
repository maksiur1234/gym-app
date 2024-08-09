<?php

namespace App\Repositories\User;

use App\Models\User\UserTrainingPlan;

class UserTrainingPlanRepository implements UserTrainingPlanRepositoryInterface
{
    public function assignPlanToUser(int $userId, int $trainingPlanId): UserTrainingPlan
    {
        return UserTrainingPlan::create([
            'user_id' => $userId,
            'training_plan_id' => $trainingPlanId
        ]);
    }

    public function getPlansForUser(int $userId): array
    {
        return UserTrainingPlan::where('user_id', $userId)->with('trainingPlan')->get()->toArray();
    }
}
