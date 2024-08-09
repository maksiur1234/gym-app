<?php

namespace App\Repositories\User;

use App\Models\User\UserTrainingPlan;

interface UserTrainingPlanRepositoryInterface
{
    public function assignPlanToUser(int $userId, int $trainingPlanId): UserTrainingPlan;
    public function getPlansForUser(int $userId): array;
}
