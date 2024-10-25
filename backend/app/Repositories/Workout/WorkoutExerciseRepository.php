<?php

namespace App\Repositories\Workout;

use App\Models\Workout\WorkoutExercise;
use App\Repositories\Workout\WorkoutExerciseRepositoryInterface;

class WorkoutExerciseRepository implements WorkoutExerciseRepositoryInterface
{
  public function create(array $data)
  {
    return WorkoutExercise::create($data);
  }
}
