<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Services\Notification\NotificationServiceInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function store(Request $request)
    {
        $result = $this->notificationService->createNotification($request->all());

        if (isset($result['errors'])) {
            return response()->json($result, 422);
        }

        if (isset($result['error'])) {
            return response()->json($result, 404);
        }

        return response()->json($result, 201);
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $notifications = $this->notificationService->getNotificationsForUser($userId);

        return response()->json(['data' => $notifications]);
    }

    public function view()
    {
        return view('notifications.index');
    }
}
