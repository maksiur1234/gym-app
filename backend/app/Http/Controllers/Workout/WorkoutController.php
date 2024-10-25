<?php
namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workout\EndTrainingRequest;
use App\Http\Requests\Workout\StartTrainingRequest;
use App\Services\Workout\WorkoutServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Exception;

class WorkoutController extends Controller
{
    protected $workoutService;

    public function __construct(WorkoutServiceInterface $workoutService)
    {
        $this->workoutService = $workoutService;
    }

    public function startTraining(StartTrainingRequest $request): JsonResponse
    {
        $user = Auth::user();

        try {
            $workoutSession = $this->workoutService->startTraining([
                'user_id' => $user->id,
                'training_plan_id' => $request->training_plan_id,
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $workoutSession->id,
            ], 201); 
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Cannot begin training.',
                'details' => $e->getMessage(), 
            ], 500);
        }
    }

    public function endTraining(EndTrainingRequest $request): JsonResponse
    {
        try {
            $workoutSession = $this->workoutService->endTraining($request->session_id, $request->validated());

            if ($workoutSession) {
                return response()->json(['message' => 'Successfully saved workout.'], 200);
            } else {
                return response()->json(['error' => 'Session not found.'], 404); 
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Cant end workout. Try again later.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
