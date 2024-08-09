<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function all(Request $request)
    {
        $page = $request->input('per_page', 10);

        $users = $this->userRepo->all($page);

        return UserResource::collection($users);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $validatedData = $request->validated();

        $user = $this->userRepo->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($validatedData);

        return new UserResource($user);
    }


    public function view()
    {
        return view('users');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    }
}
