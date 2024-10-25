<?php
namespace App\Services\Workout;

use App\Repositories\Workout\WorkoutExerciseRepositoryInterface;
use App\Repositories\Workout\WorkoutSessionRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WorkoutService implements WorkoutServiceInterface
{
    protected $workoutSessionRepo;
    protected $workoutExerciseRepo;

    public function __construct(
        WorkoutSessionRepositoryInterface $workoutSessionRepo,
        WorkoutExerciseRepositoryInterface $workoutExerciseRepo
    ) {
        $this->workoutSessionRepo = $workoutSessionRepo;
        $this->workoutExerciseRepo = $workoutExerciseRepo;
    }

    public function startTraining($data)
    {
        $session_id = $this->workoutSessionRepo->getLastSessionId();

        return $this->workoutSessionRepo->create([
            'user_id' => $data['user_id'],
            'training_plan_id' => $data['training_plan_id'],
            'session_id' => $session_id,
        ]);
    }

    public function endTraining($sessionId, $data)
    {
        $workoutSession = $this->workoutSessionRepo->find($sessionId);

        if (!$workoutSession) {
            throw new ModelNotFoundException('Workout session not found.');
        }

        $workoutSession->update([
            'total_reps' => $data['total_reps'],
            'total_sets' => $data['total_sets'],
        ]);

        foreach ($data['exercises'] as $exercise) {
            $this->workoutExerciseRepo->create([
                'workout_session_id' => $workoutSession->id,
                'exercise_name' => $exercise['name'],
                'sets' => $exercise['sets'],
                'reps' => $exercise['reps'], 
            ]);
        }

        return $workoutSession;
    }
}
