<?php
namespace App\Services\TrainingPlan;

interface ReadyTrainingPlanServiceInterface
{
    public function setDefaultTrainingPlan($userId, $trainingPlanId);

    public function getDefaultTrainingPlan($userId);
}
