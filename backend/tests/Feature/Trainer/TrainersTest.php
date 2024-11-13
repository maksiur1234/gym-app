<?php

namespace Tests\Feature\User;

use App\Models\Role;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainersTest extends TestCase
{
    use RefreshDatabase;

    public function testDisplayTrainersList()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/trainers');

        $response->assertViewIs('trainers.trainers-list');
    }

    public function testFetchTrainersPagination()
    {
        $loggedUser = User::factory()->create();
        $this->actingAs($loggedUser);

        $trainers = User::factory()->count(20)->create(['role_id' => 2]);

        $response = $this->getJson('/all-trainers');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'desc',
                    'profile_photo_path',
                ]
            ]
        ]);
    }

    public function testShowTrainerProfile()
    {
        Role::factory()->create(['id' => 2, 'name' => 'trainer']);

        $loggedUser = User::factory()->create();
        $this->actingAs($loggedUser);

        $trainer = User::factory()->create(['role_id' => 2]);

        $response = $this->get("/trainers/profile/{$trainer->id}");

        $response->assertViewIs('trainers.trainer-profile');

        $response->assertViewHas('trainerId', $trainer->id);
        $response->assertViewHas('user', $loggedUser);
    }

    public function testAboutTrainerWhenTrainerExists()
    {
        $loggedUser = User::factory()->create();
        $this->actingAs($loggedUser);

        $trainerRole = Role::factory()->create([
            'id' => 2,
            'name' => 'trainer',
        ]);

        $trainer = User::factory()->create([
            'role_id' => $trainerRole->id,
        ]);

        $response = $this->getJson("/trainers/info/{$trainer->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $trainer->id,
                     'name' => $trainer->name,
                     'email' => $trainer->email,
                 ]);
    }

    public function testAboutTrainerWhenTrainerDoesNotExist()
    {
        $loggedUser = User::factory()->create();
        $this->actingAs($loggedUser);

        $trainerRole = Role::factory()->create([
            'id' => 2,
            'name' => 'trainer',
        ]);

        User::factory()->create([
            'role_id' => $trainerRole->id,
        ]);

        $nonTrainer = User::factory()->create([
            'role_id' => 1,
            'name' => 'normal'
        ]);

        $response = $this->getJson("/trainers/info/{$nonTrainer->id}");

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Trainer not found',
                 ]);
    }

}
