<?php

namespace App\Repositories\Notification;

interface NotificationRepositoryInterface
{
    public function create(array $data);
    public function getByUserId(int $userId);
    public function getTrainerById(int $trainerId);
}
