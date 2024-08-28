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

    public function create(array $data)
    {
        return UserTrainingPlan::create($data);
    }

    public function setAllPlansAsNotDefault($userId)
    {
        UserTrainingPlan::where('user_id', $userId)->update(['is_default' => false]);
    }

    public function findByUserIdAndTrainingPlanId($userId, $trainingPlanId)
    {
        return UserTrainingPlan::where('user_id', $userId)
            ->where('training_plan_id', $trainingPlanId)
            ->first();
    }

    public function createNewDefaultPlan($userId, $trainingPlanId)
    {
        return UserTrainingPlan::create([
            'user_id' => $userId,
            'training_plan_id' => $trainingPlanId,
            'is_default' => true
        ]);
    }

    public function findDefaultPlanByUserId($userId)
    {
        return UserTrainingPlan::where('user_id', $userId)
            ->where('is_default', true)
            ->with('trainingPlan')
            ->first();
    }
    public function updateDefaultPlan($userId, $trainingPlanId)
    {
        return UserTrainingPlan::where('user_id', $userId)
            ->where('training_plan_id', $trainingPlanId)
            ->update(['is_default' => true]);
    }

}
