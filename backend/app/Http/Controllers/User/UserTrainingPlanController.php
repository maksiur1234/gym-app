<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserTrainingPlanRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTrainingPlanController extends Controller
{
    protected $userTrainingPlanRepo;

    public function __construct(UserTrainingPlanRepositoryInterface $userTrainingPlanRepo)
    {
        $this->userTrainingPlanRepo = $userTrainingPlanRepo;
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
}
