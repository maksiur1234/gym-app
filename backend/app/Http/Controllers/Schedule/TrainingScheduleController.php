<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Services\Schedule\TrainingScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingScheduleController extends Controller
{
    public function __construct(TrainingScheduleService $trainingScheduleService)
    {
        $this->trainingScheduleService = $trainingScheduleService;
    }

    public function view()
    {
        return view('schedule.index');
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->only(['training_plan_id', 'type', 'day_of_week', 'specific_date', 'start_time']);

        $schedule = $this->trainingScheduleService->createSchedule($user->id, $data);
        return response()->json($schedule);
    }

    public function index()
    {
        $user = Auth::user();
        $schedules = $this->trainingScheduleService->getSchedules($user->id);
        return response()->json($schedules);
    }

    public function destroy($id)
    {
        $this->trainingScheduleService->deleteSchedule($id);
        return response()->json(['message' => 'Schedule deleted successfully.']);
    }
}
