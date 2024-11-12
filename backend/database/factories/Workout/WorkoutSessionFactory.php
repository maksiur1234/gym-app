<?php

namespace Database\Factories\Workout;

use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\User;
use App\Models\Workout\WorkoutSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class WorkoutSessionFactory extends Factory
{
    protected $model = WorkoutSession::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'user_id' => User::factory(),
            'training_plan_id' => TrainingPlan::factory(),
            'session_id' => $this->faker->unique()->randomNumber(), 
            'total_sets' => $this->faker->numberBetween(0, 1000),
            'total_reps' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
