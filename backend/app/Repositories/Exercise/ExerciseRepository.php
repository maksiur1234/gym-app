<?php

namespace App\Repositories\Exercise;

use App\Models\Exercise\Exercise;

class ExerciseRepository implements ExerciseRepositoryInterface
{
    public function findByName(string $name)
    {
        return Exercise::where('name', $name)->first();
    }
}
