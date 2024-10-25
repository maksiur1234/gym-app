<?php

namespace App\Repositories\Statistics;

use App\Models\Workout\WorkoutExercise;
use App\Models\Workout\WorkoutSession;
use App\Repositories\Statistics\StatisticsRepositoryInterface;

class StatisticsRepository implements StatisticsRepositoryInterface
{
    public function getBasic(int $userId): array
    {
        return [
            'totalSessions' => $this->getTotalSessions($userId),
            'totalExercises' => $this->getTotalExercises($userId),
            'completedSessions' => $this->getCompletedSessions($userId),
        ];
    }

    public function getTotalSessions(int $userId): int
    {
        return WorkoutSession::where('user_id', $userId)->count();
    }

    public function getTotalExercises(int $userId): int
    {
        return WorkoutExercise::whereHas('workoutSession', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();
    }

    public function getCompletedSessions(int $userId): int
    {
        return WorkoutSession::where('user_id', $userId)->count();
    }

    public function getTotalSets(int $userId): int
    {
        return WorkoutExercise::whereHas('workoutSession', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('sets');
    }

    public function getTotalReps(int $userId): int
    {
        return WorkoutExercise::whereHas('workoutSession', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('reps');
    }

    public function getExerciseDetails(int $userId): array
    {
        return WorkoutExercise::whereHas('workoutSession', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->select('exercise_name', \DB::raw('SUM(sets) as total_sets'), \DB::raw('SUM(reps) as total_reps'))
        ->groupBy('exercise_name')
        ->get()
        ->toArray();
    }
}
