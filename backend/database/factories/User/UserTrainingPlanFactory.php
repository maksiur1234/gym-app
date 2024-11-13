<?php

namespace Database\Factories\User;

use App\Models\Role;
use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\User;
use App\Models\User\UserTrainingPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\User>
 */
class UserTrainingPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserTrainingPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $trainingPlan = TrainingPlan::factory()->create();

        return [
            'user_id' => $user->id,
            'training_plan_id' => $trainingPlan->id,
            'is_default' => false,
        ];
    }
}
