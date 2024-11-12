<?php

namespace Tests\Feature\Workout;

use App\Models\Role;
use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\User;
use App\Models\Workout\WorkoutSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WorkoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::factory()->create();

        User::factory()->create();

        TrainingPlan::factory()->create();
    }

    public function testStartTraining()
    {
        $user = User::factory()->create();
        $trainingPlan = TrainingPlan::factory()->create();

        $data = [
            'user_id' => $user->id,
            'training_plan_id' => $trainingPlan->id,
        ];

        $response = $this->actingAs($user)->postJson('/workout/start', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('workout_sessions', [
            'user_id' => $data['user_id'],
            'training_plan_id' => $data['training_plan_id'],
        ]);
    }

    public function testEndTraining()
    {
        $user = User::factory()->create();
        $workoutSession = WorkoutSession::factory()->create(['user_id' => $user->id]);

        $data = [
            'session_id' => $workoutSession->id,
            'total_reps' => 100,
            'total_sets' => 10,
            'exercises' => [
                [
                    'name' => 'Push Up',
                    'sets' => 4,
                    'reps' => 25
                ],
                [
                    'name' => 'Pull Up',
                    'sets' => 3,
                    'reps' => 20
                ],
            ]
        ];

        $response = $this->actingAs($user)->postJson('/workout/end', $data);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Successfully saved workout.']);
    }


    public function testEndTrainingWithInvalidSessionId()
    {
        $user = User::factory()->create();

        // Przypadek, w którym session_id nie istnieje w bazie
        $data = [
            'session_id' => 9999, // Zakładamy, że taki ID nie istnieje
            'total_reps' => 100,
            'total_sets' => 10,
            'exercises' => [
                [
                    'name' => 'Push Up',
                    'sets' => 4,
                    'reps' => 25
                ],
                [
                    'name' => 'Pull Up',
                    'sets' => 3,
                    'reps' => 20
                ],
            ]
        ];
    
        $response = $this->actingAs($user)->postJson('/workout/end', $data);
    
        // Sprawdzamy, czy odpowiedź ma status 500
        $response->assertStatus(500);
    
        // Sprawdzamy, czy odpowiedź zawiera odpowiedni komunikat o błędzie
        $response->assertJson([
            'error' => 'Cant end workout. Try again later.',
            'details' => 'Workout session not found.'
        ]);
    }


    public function testEndTrainingWithMissingData()
    {
        $user = User::factory()->create();

        $data = [
            'session_id' => 1,
            'total_sets' => 5,
        ];

        $response = $this->actingAs($user)->postJson('/workout/end', $data);
        $response->assertStatus(422);
    }
}
