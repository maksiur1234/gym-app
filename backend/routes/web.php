<?php

use App\Http\Controllers\TrainingPlan\TrainingPlanController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserTrainingPlanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Trainers\TrainerController;
use App\Http\Controllers\Exercise\ExerciseController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/fetch-user-data', [UserController::class, 'index'])->name('dashboard');
    Route::get('/all-users', [UserController::class, 'all']);
    Route::get('/users', [UserController::class, 'view']);
    Route::put('/update-user/{id}', [UserController::class, 'update']);

    Route::get('/roles', [RoleController::class, 'all']);

    Route::get('/exercises', [ExerciseController::class, 'index']);

    Route::get('/training-plans-data', [TrainingPlanController::class, 'getUserPlan']);
    Route::get('/training-plans', [TrainingPlanController::class, 'view']);
    Route::get('/new-training-plan', [TrainingPlanController::class, 'viewCreate'])->name('training-plans.create');
    Route::post('/store-training-plans', [TrainingPlanController::class, 'store']);

    Route::get('/trainers', [TrainerController::class, 'view']);
    Route::get('/all-trainers', [TrainerController::class, 'index']);

    Route::get('/user-training-plans', [UserTrainingPlanController::class, 'getAssignedPlan']);
    Route::post('/user-training-plans/assign', [UserTrainingPlanController::class, 'assign']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //
});
