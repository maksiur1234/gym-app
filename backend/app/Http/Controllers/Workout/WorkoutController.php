<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workout\WorkoutSession;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    public function startTraining(Request $request)
    {
        $user = Auth::user();
        $trainingPlanId = $request->input('training_plan_id');

        $session = WorkoutSession::create([
            'user_id' => $user->id,
            'training_plan_id' => $trainingPlanId,
            'start_time' => now(),
        ]);

        return response()->json([
            'success' => true,
            'session_id' => $session->id,
            'start_time' => $session->start_time,
        ]);
    }

    public function endTraining(Request $request)
    {
        $sessionId = $request->input('session_id');
        $totalSets = $request->input('total_sets');

        $session = WorkoutSession::find($sessionId);

        if ($session) {
            $session->update([
                'end_time' => now(),
                'total_sets' => $totalSets,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Trening zakończony',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sesja treningowa nie znaleziona',
        ], 404);
    }
}
