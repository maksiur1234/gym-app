<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\StoreScheduleReqeuest;
use App\Models\Schedule\TrainingSchedule;
use App\Services\Schedule\TrainingScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingScheduleController extends Controller
{
    protected $trainingScheduleService;
    public function __construct(TrainingScheduleService $trainingScheduleService)
    {
        $this->trainingScheduleService = $trainingScheduleService;
    }

    public function view()
    {
        return view('schedule.index');
    }

    public function addToSchedule(StoreScheduleReqeuest $request)
    {
        try {
            $userId = Auth::id();
            $this->trainingScheduleService->addToSchedule(
                $userId,
                $request->training_day_id,
                $request->scheduled_date
            );

            return response()->json(['message' => 'Day succesfully added to schedule.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function getSchedule()
    {
        try {
            $userId = Auth::id();
            $schedules = $this->trainingScheduleService->getSchedulesForUser($userId);
    
            return response()->json($schedules, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
