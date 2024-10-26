<?php

namespace App\Http\Controllers\TrainingPlan;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingPlan\StoreTrainingPlanRequest;
use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\UserTrainingPlan;
use App\Repositories\TrainingPlan\TrainingPlanRepositoryInterface;
use App\Services\TrainingPlan\TrainingPlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingPlanController extends Controller
{
    protected $trainingPlanRepo;
    protected $trainingPlanService;

    public function __construct(
        TrainingPlanRepositoryInterface $trainingPlanRepo,
        TrainingPlanService $trainingPlanService
    )
    {
        $this->trainingPlanRepo = $trainingPlanRepo;
        $this->trainingPlanService = $trainingPlanService;
    }

    public function view()
    {
        return view('training_plans.index');
    }

    public function getUserPlan()
    {
        $user = Auth::user();

        $trainingPlans = $this->trainingPlanRepo->getAssignedPlans($user->id);

        return response()->json($trainingPlans);
    }

    public function viewCreate()
    {
        return view('training_plans.create');
    }
    public function store(StoreTrainingPlanRequest $request)
    {
        // dd($request);
        $validatedData = $request->validated();
        
        try {
            $trainingPlan = $this->trainingPlanService->createTrainingPlan($validatedData);

            return response()->json([
                'message' => 'Training plan created successfully!',
                'trainingPlan' => $trainingPlan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function storeReady(StoreTrainingPlanRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $trainingPlan = $this->trainingPlanService->createReadyTrainingPlan($validatedData);

            return response()->json([
                'message' => 'Training plan created successfully!',
                'trainingPlan' => $trainingPlan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function show($id)
    {
        $trainingPlan = TrainingPlan::with('trainingDays.exercises')->find($id);

        if (!$trainingPlan) {
            return response()->json(['message' => 'Plan not found'], 404);
        }

        return view('training_plans.details');
    }
    public function details($id)
    {
        $trainingPlan = TrainingPlan::with('trainingDays.exercises')->find($id);

        return response()->json($trainingPlan);
    }

    public function setAsDefault(Request $request, $planId)
    {
        $user = Auth::user();
        $existingPlan = UserTrainingPlan::where('user_id', $user->id)
            ->where('training_plan_id', $planId)
            ->first();

        if ($existingPlan) {
            return response()->json(['message' => 'Training plan is deafult.'], 400);
        }

        UserTrainingPlan::updateOrCreate(
            ['user_id' => $user->id],
            ['training_plan_id' => $planId],
        );

        return response()->json(['message' => 'Training plan set as deafult.'], 200);
    }
}
