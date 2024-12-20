<?php

namespace App\Http\Controllers\Trainers;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrainerResource;
use App\Http\Resources\UserResource;
use App\Models\User\User;
use App\Repositories\Trainer\TrainerRepositoryInterface;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    protected $trainerRepository;
    public function __construct(TrainerRepositoryInterface $trainerRepository)
    {
        $this->trainerRepository = $trainerRepository;
    }

    public function view()
    {
        return view('trainers.trainers-list');
    }

    public function index(Request $request)
    {
        $page = $request->input('per_page', 10);

        $trainers = $this->trainerRepository->all($page);

        return TrainerResource::collection($trainers);
    }

    public function showProfile($id)
    {
        $user = User::where('id', auth()->id())->select(['id', 'name', 'email'])->first();
        return view('trainers.trainer-profile', [
            'trainerId' => $id,
            'user' => $user,
        ]);
    }

    public function aboutTrainer($id)
    {
        $trainer = User::where('role_id', Role::Trainer->value)->find($id);

        if (!$trainer) {
            return response()->json(['message' => 'Trainer not found'], 404);
        }

        return response()->json($trainer);
    }
}
