<?php

namespace Database\Factories\TrainingPlan;

use App\Models\TrainingPlan\TrainingPlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingPlan\TrainingPlan>
 */
class TrainingPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrainingPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'desc' => $this->faker->paragraph,
            'created_by' => 1,
            'price' => $this->faker->randomFloat,
            'is_global' => $this->faker->boolean
        ];
    }
}
