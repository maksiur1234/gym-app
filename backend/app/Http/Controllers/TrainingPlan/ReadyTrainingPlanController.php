<?php
namespace App\Http\Controllers\TrainingPlan;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingPlan\StoreTrainingPlanRequest;
use App\Models\TrainingPlan\ReadyTrainingPlan;
use App\Models\TrainingPlan\TrainingPlan;
use App\Repositories\TrainingPlan\ReadyTrainingPlanRepository;
use App\Services\TrainingPlan\ReadyTrainingPlanService;

class ReadyTrainingPlanController extends Controller
{
    protected $trainingPlanRepo;
    protected $trainingPlanService;
    public function __construct(
        ReadyTrainingPlanRepository $trainingPlanRepo,
        ReadyTrainingPlanService $trainingPlanService
    )
    {
        $this->trainingPlanRepo = $trainingPlanRepo;
        $this->trainingPlanService = $trainingPlanService;
    }
    public function view()
    {
        return view('ready_training_plans.index');
    }
    public function index()
    {
        $trainingPlans = ReadyTrainingPlan::all();

        return response()->json(['data' => $trainingPlans]);
    }

    public function store(StoreTrainingPlanRequest $request)
    {
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
}
