<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Workout\WorkoutSession;
use App\Models\Workout\WorkoutExercise;
use App\Repositories\Statistics\StatisticsRepositoryInterface;

class StatsController extends Controller
{
    
    protected $statsRepository;

    public function __construct(StatisticsRepositoryInterface $statsRepository)
    {
        $this->statsRepository = $statsRepository;
    }

    public function index()
    {
        return view('statistics.index');
    }
    public function getStats()
    {
        $user = Auth::user();
        
        $stats = [
            'basic' => $this->statsRepository->getBasic($user->id),
            'totalSets' => $this->statsRepository->getTotalSets($user->id),
            'totalReps' => $this->statsRepository->getTotalReps($user->id),
            'exerciseDetails' => $this->statsRepository->getExerciseDetails($user->id),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }
}
