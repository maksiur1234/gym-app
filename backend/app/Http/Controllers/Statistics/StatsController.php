<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Workout\WorkoutSession;
use App\Models\Workout\WorkoutExercise;

class StatsController extends Controller
{
    public function getStats()
    {
        $user = Auth::user();

        $totalSessions = WorkoutSession::where('user_id', $user->id)->count();
        $totalExercises = WorkoutExercise::whereHas('workoutSession', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
        $completedSessions = WorkoutSession::where('user_id', $user->id)->count();

        $totalSets = WorkoutExercise::whereHas('workoutSession', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('sets');

        $totalReps = WorkoutExercise::whereHas('workoutSession', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('reps');

        $exerciseDetails = WorkoutExercise::whereHas('workoutSession', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->select('exercise_name', \DB::raw('SUM(sets) as total_sets'), \DB::raw('SUM(reps) as total_reps'))
        ->groupBy('exercise_name')
        ->get();

        return response()->json([
            'success' => true,
            'totalSessions' => $totalSessions,
            'totalExercises' => $totalExercises,
            'completedSessions' => $completedSessions,
            'totalSets' => $totalSets,
            'totalReps' => $totalReps,
            'exerciseDetails' => $exerciseDetails,
        ]);
    }
}
