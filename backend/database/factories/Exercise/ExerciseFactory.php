<?php

namespace Database\Factories\Exercise;

use App\Models\Exercise\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Exercise::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'desc' => $this->faker->sentence,
            'exercise_type' => $this->faker->randomElement(['push', 'pull']),
        ];
    }
}
