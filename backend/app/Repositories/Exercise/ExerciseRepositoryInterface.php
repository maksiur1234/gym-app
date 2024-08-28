<?php
namespace App\Repositories\Exercise;

interface ExerciseRepositoryInterface
{
    public function findByName(string $name);
}
