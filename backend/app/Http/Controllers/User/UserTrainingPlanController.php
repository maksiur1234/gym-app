<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\UserTrainingPlan;
use App\Repositories\User\UserTrainingPlanRepositoryInterface;
use App\Services\TrainingPlan\TrainingPlanServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTrainingPlanController extends Controller
{
    protected $userTrainingPlanRepo;
    protected $trainingPlanService;

    public function __construct(
        UserTrainingPlanRepositoryInterface $userTrainingPlanRepo,
        TrainingPlanServiceInterface $trainingPlanService
    )
    {
        $this->userTrainingPlanRepo = $userTrainingPlanRepo;
        $this->trainingPlanService = $trainingPlanService;
    }

    public function index()
    {
        $userId = Auth::id();

        $assignedPlans = $this->userTrainingPlanRepo->getPlansForUser($userId);

        return view('user_training_plans.index', compact('assignedPlans'));
    }
    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'training_plan_id' => 'required|exists:training_plans,id',
        ]);

        $this->userTrainingPlanRepo->assignPlanToUser(
            $request->input('user_id'),
            $request->input('training_plan_id')
        );

        return redirect('/user-training-plans');
    }

    public function getAssignedPlan()
    {
        $userId = Auth::id();
        $plans = $this->userTrainingPlanRepo->getPlansForUser($userId);

        return response()->json($plans);
    }

    public function setDefaultTrainingPlan(Request $request)
    {
        $user = Auth::user();
        $trainingPlanId = $request->input('training_plan_id');

        $response = $this->trainingPlanService->setDefaultTrainingPlan($user->id, $trainingPlanId);

        return response()->json($response);
    }

    public function getDefaultTrainingPlan()
    {
        $user = Auth::user();

        [$response, $status] = $this->trainingPlanService->getDefaultTrainingPlan($user->id);

        return response()->json($response, $status ?? 200);
    }
}
