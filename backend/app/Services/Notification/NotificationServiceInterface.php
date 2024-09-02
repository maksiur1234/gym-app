<?php

namespace App\Services\Notification;

interface NotificationServiceInterface
{
    public function createNotification(array $data);
    public function getNotificationsForUser(int $userId);
}
