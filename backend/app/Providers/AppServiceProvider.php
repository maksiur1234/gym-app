<?php

namespace App\Providers;

use App\Models\TrainingPlan\TrainingDayExercise;
use App\Models\User\User;
use App\Policies\User\UserPolicy;
use App\Repositories\Exercise\ExerciseRepository;
use App\Repositories\Exercise\ExerciseRepositoryInterface;
use App\Repositories\Trainer\TrainerRepository;
use App\Repositories\Trainer\TrainerRepositoryInterface;
use App\Repositories\TrainingPlan\TrainingDayExerciseRepository;
use App\Repositories\TrainingPlan\TrainingDayExerciseRepositoryInterface;
use App\Repositories\TrainingPlan\TrainingDayRepository;
use App\Repositories\TrainingPlan\TrainingDayRepositoryInterface;
use App\Repositories\TrainingPlan\TrainingPlanRepository;
use App\Repositories\TrainingPlan\TrainingPlanRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserTrainingPlanRepository;
use App\Repositories\User\UserTrainingPlanRepositoryInterface;
use App\Services\TrainingPlan\TrainingPlanService;
use App\Services\TrainingPlan\TrainingPlanServiceInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
      User::class => UserPolicy::class,
    ];

    public function register(): void
    {
        $this->app->bind(TrainingPlanRepositoryInterface::class, TrainingPlanRepository::class);
        $this->app->bind(UserTrainingPlanRepositoryInterface::class, UserTrainingPlanRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TrainerRepositoryInterface::class, TrainerRepository::class);
        $this->app->bind(ExerciseRepositoryInterface::class, ExerciseRepository::class);
        $this->app->bind(TrainingDayRepositoryInterface::class, TrainingDayRepository::class);
        $this->app->bind(TrainingDayExerciseRepositoryInterface::class, TrainingDayExerciseRepository::class);
        $this->app->bind(UserTrainingPlanRepositoryInterface::class, UserTrainingPlanRepository::class);
        $this->app->bind(TrainingPlanServiceInterface::class, TrainingPlanService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       //
    }
}
