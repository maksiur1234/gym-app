<?php

namespace App\Providers;

use App\Models\User\User;
use App\Policies\User\UserPolicy;
use App\Repositories\Trainer\TrainerRepository;
use App\Repositories\Trainer\TrainerRepositoryInterface;
use App\Repositories\TrainingPlan\TrainingPlanRepository;
use App\Repositories\TrainingPlan\TrainingPlanRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserTrainingPlanRepository;
use App\Repositories\User\UserTrainingPlanRepositoryInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       //
    }
}
