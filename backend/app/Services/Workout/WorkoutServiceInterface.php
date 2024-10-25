<?php
namespace App\Services\Workout;

interface WorkoutServiceInterface
{
    public function startTraining($data);
    public function endTraining($sessionId, $data);
}
