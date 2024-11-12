<?php

namespace Tests\Unit;

use App\Services\Workout\WorkoutService;
use App\Repositories\Workout\WorkoutSessionRepositoryInterface;
use App\Repositories\Workout\WorkoutExerciseRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class WorkoutTest extends TestCase
{
    protected $workoutService;
    protected $workoutSessionRepoMock;
    protected $workoutExerciseRepoMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workoutSessionRepoMock = Mockery::mock(WorkoutSessionRepositoryInterface::class);
        $this->workoutExerciseRepoMock = Mockery::mock(WorkoutExerciseRepositoryInterface::class);

        $this->workoutService = new WorkoutService(
            $this->workoutSessionRepoMock,
            $this->workoutExerciseRepoMock
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testStartTrainingSuccessfully()
    {
        $data = [
            'user_id' => 1,
            'training_plan_id' => 1,
        ];

        $this->workoutSessionRepoMock
            ->shouldReceive('getLastSessionId')
            ->once()
            ->andReturn(123);

        $this->workoutSessionRepoMock
            ->shouldReceive('create')
            ->once()
            ->with([
                'user_id' => $data['user_id'],
                'training_plan_id' => $data['training_plan_id'],
                'session_id' => 123,
            ])
            ->andReturn((object) ['id' => 1]);

        $result = $this->workoutService->startTraining($data);

        $this->assertEquals(1, $result->id);
    }

    public function testEndTrainingSuccessfully()
    {
        $sessionId = 1;
        $data = [
            'total_reps' => 50,
            'total_sets' => 10,
            'exercises' => [
                ['name' => 'Push Up', 'sets' => 5, 'reps' => 10],
                ['name' => 'Squat', 'sets' => 5, 'reps' => 10],
            ],
        ];

        $workoutSessionMock = Mockery::mock();
        $workoutSessionMock->id = $sessionId;
        $workoutSessionMock
            ->shouldReceive('update')
            ->once()
            ->with([
                'total_reps' => $data['total_reps'],
                'total_sets' => $data['total_sets'],
            ])
            ->andReturnTrue();

        $this->workoutSessionRepoMock
            ->shouldReceive('find')
            ->once()
            ->with($sessionId)
            ->andReturn($workoutSessionMock);

        foreach ($data['exercises'] as $exercise) {
            $this->workoutExerciseRepoMock
                ->shouldReceive('create')
                ->once()
                ->with([
                    'workout_session_id' => $sessionId,
                    'exercise_name' => $exercise['name'],
                    'sets' => $exercise['sets'],
                    'reps' => $exercise['reps'],
                ])
                ->andReturnTrue();
        }

        $result = $this->workoutService->endTraining($sessionId, $data);

        $this->assertEquals($sessionId, $result->id);
    }

    public function testEndTrainingThrowsExceptionWhenSessionNotFound()
    {
        $this->expectException(ModelNotFoundException::class);

        $sessionId = 999;
        $data = [
            'total_reps' => 50,
            'total_sets' => 10,
            'exercises' => [
                ['name' => 'Push Up', 'sets' => 5, 'reps' => 10],
            ],
        ];

        $this->workoutSessionRepoMock
            ->shouldReceive('find')
            ->once()
            ->with($sessionId)
            ->andReturn(null);

        $this->workoutService->endTraining($sessionId, $data);
    }
}
