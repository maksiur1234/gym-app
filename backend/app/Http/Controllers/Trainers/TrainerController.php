<?php

namespace App\Http\Controllers\Trainers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TrainerResource;
use App\Http\Resources\UserResource;
use App\Models\User\User;
use App\Repositories\Trainer\TrainerRepositoryInterface;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
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
}
