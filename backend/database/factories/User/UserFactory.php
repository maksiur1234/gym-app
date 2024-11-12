<?php

namespace Database\Factories\User;

use App\Models\Role;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = Role::factory()->create();

        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'weight' => $this->faker->numberBetween(50, 100),
            'height' => $this->faker->numberBetween(150, 200),
            'age' => $this->faker->numberBetween(18, 60),
            'training_intership' => $this->faker->numberBetween(1, 10),
            'desc' => $this->faker->paragraph,
            'role_id' => $role->id,
            'profile_photo_path' => $this->faker->imageUrl,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
        ];
    }
}
