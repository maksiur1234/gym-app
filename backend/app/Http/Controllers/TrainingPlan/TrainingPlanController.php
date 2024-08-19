<?php

namespace App\Http\Controllers\TrainingPlan;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingPlan\StoreTrainingPlanRequest;
use App\Models\TrainingPlan\TrainingDay;
use App\Models\TrainingPlan\TrainingDayExercise;
use App\Models\TrainingPlan\TrainingPlan;
use App\Repositories\TrainingPlan\TrainingPlanRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainingPlanController extends Controller
{
    protected $trainingPlanRepo;

    public function __construct(TrainingPlanRepositoryInterface $trainingPlanRepo)
    {
        $this->trainingPlanRepo = $trainingPlanRepo;
    }

    public function view()
    {
        return view('training_plans.index');
    }

    public function getUserPlan()
    {
        $user = Auth::user();

        $trainingPlans = $this->trainingPlanRepo->getByUserId($user->id);

        return response()->json($trainingPlans);
    }

    public function viewCreate()
    {
        return view('training_plans.create');
    }

    public function store(Request $request)
    {
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'desc' => 'nullable|string',
//            'user_id' => 'required|exists:users,id',
//            'days' => 'required|array',
//            'days.*.day_name' => 'required|string',
//            'days.*.exercises' => 'required|array',
//            'days.*.exercises.*.exercise_id' => 'required|exists:exercises,id',
//            'days.*.exercises.*.series' => 'required|integer',
//            'days.*.exercises.*.repetitions' => 'required|integer',
//            'days.*.exercises.*.rir' => 'nullable|integer',
//            'days.*.exercises.*.tempo' => 'nullable|string',
//            'days.*.exercises.*.break' => 'nullable|string',
//        ]);

        DB::transaction(function () use ($request) {
            // Tworzenie planu treningowego
            $trainingPlan = TrainingPlan::create([
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
                'created_by' => auth()->id(),
                'user_id' => $request->input('user_id'),
            ]);

            foreach ($request->input('days') as $day) {
                // Tworzenie dni treningowych
                $trainingDay = TrainingDay::create([
                    'training_plan_id' => $trainingPlan->id,
                    'day_name' => $day['day_name'],
                ]);

                foreach ($day['exercises'] as $exercise) {
                    // Dodawanie ćwiczeń do dni treningowych
                    TrainingDayExercise::create([
                        'training_day_id' => $trainingDay->id,
                        'exercise_id' => $exercise['exercise_id'],
                        'series' => $exercise['series'],
                        'repetitions' => $exercise['repetitions'],
                        'rir' => $exercise['rir'],
                        'tempo' => $exercise['tempo'],
                        'break' => $exercise['break'],
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Plan treningowy zapisany pomyślnie.']);
    }

}
