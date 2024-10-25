<?php

namespace App\Providers;

use App\Models\TrainingPlan\TrainingDayExercise;
use App\Models\User\User;
use App\Models\Workout\WorkoutExercise;
use App\Policies\User\UserPolicy;
use App\Repositories\Exercise\ExerciseRepository;
use App\Repositories\Exercise\ExerciseRepositoryInterface;
use App\Repositories\Message\MessageRepository;
use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\Trainer\TrainerRepository;
use App\Repositories\Trainer\TrainerRepositoryInterface;
use App\Repositories\TrainingPlan\ReadyTrainingPlanRepository;
use App\Repositories\TrainingPlan\ReadyTrainingPlanRepositoryInterface;
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
use App\Services\TrainingPlan\ReadyTrainingPlanService;
use App\Services\TrainingPlan\ReadyTrainingPlanServiceInterface;
use App\Services\TrainingPlan\TrainingPlanService;
use App\Services\TrainingPlan\TrainingPlanServiceInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Schedule\TrainingScheduleRepository;
use App\Repositories\Schedule\TrainingScheduleRepositoryInterface;
use App\Repositories\Statistics\StatisticsRepository;
use App\Repositories\Statistics\StatisticsRepositoryInterface;
use App\Repositories\Workout\WorkoutExerciseRepository;
use App\Repositories\Workout\WorkoutExerciseRepositoryInterface;
use App\Repositories\Workout\WorkoutSessionRepository;
use App\Repositories\Workout\WorkoutSessionRepositoryInterface;
use App\Services\Notification\NotificationService;
use App\Services\Notification\NotificationServiceInterface;
use App\Services\Workout\WorkoutService;
use App\Services\Workout\WorkoutServiceInterface;
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
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
        $this->app->bind(TrainingScheduleRepositoryInterface::class, TrainingScheduleRepository::class);
        $this->app->bind(WorkoutServiceInterface::class, WorkoutService::class);
        $this->app->bind(WorkoutExerciseRepositoryInterface::class, WorkoutExerciseRepository::class);
        $this->app->bind(WorkoutSessionRepositoryInterface::class, WorkoutSessionRepository::class);
        $this->app->bind(StatisticsRepositoryInterface::class, StatisticsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       //
    }
}
