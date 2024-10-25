<?php
namespace App\Repositories\Statistics;

interface StatisticsRepositoryInterface
{
    public function getBasic(int $userId): array;

    public function getTotalSessions(int $userId): int;

    public function getTotalExercises(int $userId): int;

    public function getCompletedSessions(int $userId): int;

    public function getTotalSets(int $userId): int;

    public function getTotalReps(int $userId): int;

    public function getExerciseDetails(int $userId): array;
}