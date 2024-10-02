<?php
namespace App\Services\TrainingPlan;

use App\Models\User\UserTrainingPlan;
use App\Repositories\TrainingPlan\TrainingPlanRepositoryInterface;
use App\Repositories\TrainingPlan\TrainingDayRepositoryInterface;
use App\Repositories\TrainingPlan\TrainingDayExerciseRepositoryInterface;
use App\Repositories\User\UserTrainingPlanRepositoryInterface;
use App\Repositories\Exercise\ExerciseRepositoryInterface;

class TrainingPlanService implements TrainingPlanServiceInterface
{
    protected $trainingPlanRepo;
    protected $exerciseRepo;
    protected $trainingDayRepo;
    protected $trainingDayExerciseRepo;
    protected $userTrainingPlanRepo;

    public function __construct(
        TrainingPlanRepositoryInterface $trainingPlanRepo,
        ExerciseRepositoryInterface $exerciseRepo,
        TrainingDayRepositoryInterface $trainingDayRepo,
        TrainingDayExerciseRepositoryInterface $trainingDayExerciseRepo,
        UserTrainingPlanRepositoryInterface $userTrainingPlanRepo,
    )
    {
        $this->trainingPlanRepo = $trainingPlanRepo;
        $this->exerciseRepo = $exerciseRepo;
        $this->trainingDayRepo = $trainingDayRepo;
        $this->trainingDayExerciseRepo = $trainingDayExerciseRepo;
        $this->userTrainingPlanRepo = $userTrainingPlanRepo;
    }
    public function createTrainingPlan(array $data)
    {
        $trainingPlan = $this->trainingPlanRepo->create([
            'name' => $data['planName'],
            'desc' => $data['planDesc'],
            'created_by' => $data['user_id'],
            'user_id' => $data['user_id'],
        ]);

        // add training days and exercises
        foreach (range(1, $data['trainingDays']) as $dayIndex) {
            $trainingDay = $this->trainingDayRepo->create([
                'training_plan_id' => $trainingPlan->id,
                'day_name' => 'Dzień ' . $dayIndex,
            ]);

            if (isset($data['rows'][$dayIndex])) {
                foreach ($data['rows'][$dayIndex] as $exerciseData) {
                    $exercise = $this->exerciseRepo->findByName($exerciseData['name']);

                    if ($exercise) {
                        $this->trainingDayExerciseRepo->create([
                            'training_day_id' => $trainingDay->id,
                            'exercise_id' => $exercise->id,
                            'sets' => $exerciseData['sets'],
                            'reps' => $exerciseData['reps'],
                            'rir' => $exerciseData['rir'],
                            'tempo' => $exerciseData['tempo'],
                            'break' => $exerciseData['break'],
                        ]);
                    } else {
                        throw new \Exception('Exercise not found: ' . $exerciseData['name']);
                    }
                }
            } else {
                throw new \Exception('No exercises provided for day ' . $dayIndex);
            }
        }

        $this->userTrainingPlanRepo->create([
            'user_id' => $data['user_id'],
            'training_plan_id' => $trainingPlan->id,
        ]);

        return $trainingPlan;
    }
    public function setDefaultTrainingPlan($userId, $trainingPlanId)
    {
        \Log::info('Attempting to set default training plan', [
            'user_id' => $userId,
            'training_plan_id' => $trainingPlanId,
        ]);

        $this->userTrainingPlanRepo->setAllPlansAsNotDefault($userId);

        $existingPlan = $this->userTrainingPlanRepo->findByUserIdAndTrainingPlanId($userId, $trainingPlanId);

        if ($existingPlan) {
            \Log::info('Updating existing training plan', [
                'user_id' => $userId,
                'training_plan_id' => $trainingPlanId,
            ]);

            $this->userTrainingPlanRepo->updateDefaultPlan($userId, $trainingPlanId);
        } else {
            \Log::info('Creating new default training plan', [
                'user_id' => $userId,
                'training_plan_id' => $trainingPlanId,
            ]);

            $this->userTrainingPlanRepo->createNewDefaultPlan($userId, $trainingPlanId);
        }

        \Log::info('Default training plan set successfully', ['user_id' => $userId]);

        return ['message' => 'Default training plan updated successfully.'];
    }

    public function getDefaultTrainingPlan($userId)
    {
        $defaultPlan = $this->userTrainingPlanRepo->findDefaultPlanByUserId($userId);

        if (!$defaultPlan) {
            \Log::info('No default training plan found', ['user_id' => $userId]);
            return [['message' => 'No default training plan found.'], 404];
        }

        \Log::info('Returning default training plan', ['user_id' => $userId, 'training_plan_id' => $defaultPlan->training_plan_id]);

        return [$defaultPlan->trainingPlan, 200];
    }
}
