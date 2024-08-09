<?php
namespace App\Repositories\TrainingPlan;

interface TrainingPlanRepositoryInterface
{
    public function store(array $data);
    public function find(int $id);
    public function getAll(): array;
    public function getByUserId($userId);
}
