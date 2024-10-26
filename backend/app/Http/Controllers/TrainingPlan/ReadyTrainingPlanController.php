<?php
namespace App\Http\Controllers\TrainingPlan;

use App\Http\Controllers\Controller;
use App\Models\TrainingPlan\TrainingPlan;

class ReadyTrainingPlanController extends Controller
{
   public function index()
   {
      return view('ready_training_plans.index');
   }

   public function plans()
   {
      $plans = TrainingPlan::where('is_global', true)->get();
      
      return response()->json($plans);
   }
}
