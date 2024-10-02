<?php

namespace App\Repositories\Notification;

use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Models\Notification\Notification;
use Illuminate\Support\Facades\DB;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function create(array $data)
    {
        return Notification::create($data);
    }

    public function getByUserId(int $userId)
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getTrainerById(int $trainerId)
    {
        return DB::table('users')->where('id', $trainerId)->where('role_id', 1)->first();
    }
}
