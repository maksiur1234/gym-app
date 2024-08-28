<?php
namespace App\Repositories\TrainingPlan;

use App\Models\TrainingPlan\TrainingDayExercise;

class TrainingDayExerciseRepository implements TrainingDayExerciseRepositoryInterface
{
    public function create(array $data)
    {
        return TrainingDayExercise::create($data);
    }
}
