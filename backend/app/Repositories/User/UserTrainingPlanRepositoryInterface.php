<?php

namespace App\Repositories\User;

use App\Models\User\UserTrainingPlan;

interface UserTrainingPlanRepositoryInterface
{
    public function assignPlanToUser(int $userId, int $trainingPlanId): UserTrainingPlan;
    public function getPlansForUser(int $userId): array;
    public function setAllPlansAsNotDefault($userId);
    public function findByUserIdAndTrainingPlanId($userId, $trainingPlanId);
    public function createNewDefaultPlan($userId, $trainingPlanId);
    public function findDefaultPlanByUserId($userId);
    public function updateDefaultPlan($userId, $trainingPlanId);
}
