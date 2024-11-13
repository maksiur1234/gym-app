<?php

namespace Tests\Unit\User;

use App\Models\Role;
use App\Models\TrainingPlan\TrainingPlan;
use App\Models\User\User;
use App\Models\User\UserTrainingPlan;
use App\Repositories\User\UserTrainingPlanRepositoryInterface;
use App\Services\TrainingPlan\TrainingPlanServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function testAssignPlanToUserWithNonExistentTrainingPlan()
    {
        $user = User::factory()->create();
        $nonExistingTrainingPlanId = 999999;

        $this->mockRepo
            ->shouldReceive('assignPlanToUser')
            ->with($user->id, $nonExistingTrainingPlanId)
            ->andThrow(new ModelNotFoundException());
        
        $this->expectException(ModelNotFoundException::class);

        $this->mockRepo->assignPlanToUser($user->id, $nonExistingTrainingPlanId);
    }

    public function testAssignPlanToNonExistingUser()
    {
        $nonExistingUserId = 9999999;
        $trainingPlan = TrainingPlan::factory()->create();

        $this->mockRepo
            ->shouldReceive('assignPlanToUser')
            ->with($nonExistingUserId, $trainingPlan->id)
            ->andThrow(new ModelNotFoundException());

        $this->expectException(ModelNotFoundException::class);

        $this->mockRepo->assignPlanToUser($nonExistingUserId, $trainingPlan->id);
    }

    public function testGetPlansForUser()
    {
        $user = User::factory()->create();

        $plans = UserTrainingPlan::factory()->count(10)->make(['user_id' => $user->id]);

        $this->mockRepo
            ->shouldReceive('getPlansForUser')
            ->with($user->id)
            ->andReturn($plans->toArray());

        $result = $this->mockRepo->getPlansForUser($user->id);

        $this->assertCount(10, $result);
    }

    public function testGetPlansForUserWhenNoPlansAssigned()
    {
        $user = User::factory()->create(['id' => 9999999999999]);

        $this->mockRepo
            ->shouldReceive('getPlansForUser')
            ->with($user->id)
            ->andReturn([]);

        $result = $this->mockRepo->getPlansForUser($user->id);

        $this->assertCount(0, $result);
    }
}
