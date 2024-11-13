<?php

namespace Tests\Feature\User;

use App\Models\Role;
use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\User;
use App\Models\User\UserTrainingPlan;
use App\Repositories\User\UserTrainingPlanRepositoryInterface;
use App\Services\TrainingPlan\TrainingPlanServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTrainingPlanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRepo = $this->mock(UserTrainingPlanRepositoryInterface::class);
        $this->mockService = $this->mock(TrainingPlanServiceInterface::class);
    }

    public function testAssignValidatesTrainingPlanToUser()
    {
        $user = User::factory()->create();
        $trainingPlan = TrainingPlan::factory()->create();

        $this->mockRepo->shouldReceive('assignPlanToUser')
            ->once()
            ->with($user->id, $trainingPlan->id)
            ->andReturn(new UserTrainingPlan([
                'user_id' => $user->id,
                'training_plan_id' => $trainingPlan->id,
            ]));

        $response = $this->actingAs($user)->post('/user-training-plans/assign', [
            'user_id' => $user->id,
            'training_plan_id' => $trainingPlan->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/user-training-plans');
    }

    public function testGetAssignedPlanReturnsUserPlans()
    {
        $user = User::factory()->create();
        $trainingPlan = TrainingPlan::factory()->create();
        
        $userTrainingPlan = UserTrainingPlan::create([
            'user_id' => $user->id,
            'training_plan_id' => $trainingPlan->id
        ]);

        $this->mockRepo->shouldReceive('getPlansForUser')
            ->once()
            ->with($user->id)
            ->andReturn([$userTrainingPlan]);

        $this->actingAs($user);

        $response = $this->get('/user-training-plans'); 

        $response->assertStatus(200);
        $response->assertJson([
            [
                'user_id' => $user->id,
                'training_plan_id' => $trainingPlan->id,
            ]
        ]);
    }

    public function testSetDeafultUserTrainingPlan()
    {
        $user = User::factory()->create();
        $trainingPlan = TrainingPlan::factory()->create();

        $this->mockService->shouldReceive('setDefaultTrainingPlan')
            ->once()
            ->with($user->id, $trainingPlan->id)
            ->andReturn(['status' => 'success']); 

        $this->actingAs($user);

        $response = $this->postJson('/user/set-default-plan', [
            'training_plan_id' => $trainingPlan->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
        ]);
    }

    public function testGetDefaultUserTrainingPlan()
    {
        $user = User::factory()->create();
        $trainingPlan = TrainingPlan::factory()->create();
        $userTrainingPlan = UserTrainingPlan::factory()->create([
            'user_id' => $user->id,
            'training_plan_id' => $trainingPlan->id,
            'is_default' => true,
        ]);
    
        $this->mockService->shouldReceive('getDefaultTrainingPlan')
            ->once()
            ->with($user->id)
            ->andReturn([$userTrainingPlan, 200]);
    
        $this->actingAs($user);
    
        $response = $this->getJson('/user/get-default-plan');  
    
        $response->assertStatus(200);
    
        $response->assertJsonFragment([
            'user_id' => $user->id,
            'training_plan_id' => $trainingPlan->id,
            'is_default' => true,
        ]);
    
        $response->assertJsonFragment([
            'id' => $userTrainingPlan->id, 
        ]);
    }
    

}
