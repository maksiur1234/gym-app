<?php

namespace App\Http\Controllers\TrainingPlan;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingPlan\StoreTrainingPlanRequest;
use App\Repositories\TrainingPlan\TrainingPlanRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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

    public function store(StoreTrainingPlanRequest $request)
    {
        $validatedData = $request->validated();

        $trainingPlan = $this->trainingPlanRepo->store($validatedData);

        return response()->json([
            'message' => 'Training plan created successfully',
            'training_plan' => $trainingPlan
        ], 201);
    }

}
