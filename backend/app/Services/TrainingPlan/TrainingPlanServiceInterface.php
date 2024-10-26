<?php
namespace App\Services\TrainingPlan;

interface TrainingPlanServiceInterface
{
    public function setDefaultTrainingPlan($userId, $trainingPlanId);

    public function getDefaultTrainingPlan($userId);
    public function createTrainingPlan(array $data);
}
