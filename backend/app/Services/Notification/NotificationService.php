<?php

namespace App\Services\Notification;

use App\Services\Notification\NotificationServiceInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class NotificationService implements NotificationServiceInterface
{
    protected $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function createNotification(array $data)
    {
        $validator = Validator::make($data, [
            'userId' => 'required|integer|exists:users,id',
            'trainerId' => 'required|integer|exists:users,id',
            'message' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        $trainer = $this->notificationRepository->getTrainerById($data['trainerId']);

        if (!$trainer) {
            return ['error' => 'Trainer doesnt exist or wrong role_id.'];
        }

        $notification = $this->notificationRepository->create([
            'user_id' => $data['userId'],
            'trainer_id' => $data['trainerId'],
            'message' => $data['message'],
        ]);

        return ['success' => true, 'notification' => $notification];
    }

    public function getNotificationsForUser(int $userId)
    {
        return $this->notificationRepository->getByUserId($userId);
    }
}
