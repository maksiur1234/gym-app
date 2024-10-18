<?php

use App\Http\Controllers\TrainingPlan\TrainingPlanController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserTrainingPlanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Trainers\TrainerController;
use App\Http\Controllers\Exercise\ExerciseController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Schedule\TrainingScheduleController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\SkillTree\SkillTreeController;
use App\Http\Controllers\TrainingPlan\ReadyTrainingPlanController;
use App\Http\Controllers\Stripe\StripeController;
use App\Http\Controllers\Workout\WorkoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/fetch-user-data', [UserController::class, 'index'])->name('user-data');
    Route::get('/all-users', [UserController::class, 'all']);
    Route::get('/users', [UserController::class, 'view']);
    Route::put('/update-user/{id}', [UserController::class, 'update']);

    Route::get('/roles', [RoleController::class, 'all']);

    Route::get('/exercises', [ExerciseController::class, 'index']);

    Route::get('/training-plans-data', [TrainingPlanController::class, 'getUserPlan']);
    Route::get('/training-plans', [TrainingPlanController::class, 'view']);
    Route::get('/new-training-plan', [TrainingPlanController::class, 'viewCreate'])->name('training-plans.create');
    Route::post('/store-training-plans', [TrainingPlanController::class, 'store']);
    Route::post('/store-ready-training-plans', [TrainingPlanController::class, 'storeReady']);
    Route::get('/training-plan-details/{id}', [TrainingPlanController::class, 'show']);
    Route::get('/training-plan-details-data/{id}', [TrainingPlanController::class, 'details']);
    Route::post('/training-plan/{id}/set-default', [TrainingPlanController::class, 'setAsDefault']);

    Route::get('/ready-training-plans', [ReadyTrainingPlanController::class, 'index']);
    Route::get('/ready-training-plans-data', [ReadyTrainingPlanController::class, 'plans']);
    
    Route::get('/trainers', [TrainerController::class, 'view']);
    Route::get('/all-trainers', [TrainerController::class, 'index']);
    Route::get('/trainers/profile/{id}', [TrainerController::class, 'showProfile']);
    Route::get('/trainers/info/{id}', [TrainerController::class, 'aboutTrainer']);

    Route::get('/user-training-plans', [UserTrainingPlanController::class, 'getAssignedPlan']);
    Route::post('/user-training-plans/assign', [UserTrainingPlanController::class, 'assign']);
    Route::get('/user/get-default-plan', [UserTrainingPlanController::class, 'getDefaultTrainingPlan']);
    Route::post('/user/set-default-plan', [UserTrainingPlanController::class, 'setDefaultTrainingPlan']);

    Route::get('/schedule', [TrainingScheduleController::class, 'view']);
    Route::get('/schedules/{userId}', [TrainingScheduleController::class, 'index']);
    Route::post('/schedules', [TrainingScheduleController::class, 'store']);
    Route::delete('/schedules/{id}', [TrainingScheduleController::class, 'destroy']);

    Route::get('/global-chat', [MessageController::class, 'view'])->name('chat.show');
    Route::get('/all-chats', [MessageController::class, 'index']);
    Route::get('/messages', [MessageController::class, 'messages'])->name('messages');
    Route::post('/message', [MessageController::class, 'message'])->name('message');
    Route::get('/chat/private/{receiverId}', [MessageController::class, 'getPrivateMessages'])->name('private.messages');
    Route::get('/chat/{receiverId}', [MessageController::class, 'viewPrivate'])->name('private.chat');
    Route::get('/chats', [MessageController::class, 'getActiveChats']);
    Route::post('/accept-message/{id}', [MessageController::class, 'acceptRequest'])->name('accept-message');
    Route::post('/reject-message/{id}', [MessageController::class, 'rejectRequest'])->name('reject-message');

    Route::get('/stripe', [StripeController::class, 'index'])->name('index');
    Route::post('/checkout', [StripeController::class, 'checkout'])->name('checkout');
    Route::get('/success', [StripeController::class, 'success'])->name('success');

    Route::post('/workout/start', [WorkoutController::class, 'startTraining']);
    Route::post('/workout/end', [WorkoutController::class, 'endTraining']);

    Route::get('/skill-tree', [SkillTreeController::class, 'index']);
    Route::get('/get-level', [SkillTreeController::class, 'skillLevel']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //
});
