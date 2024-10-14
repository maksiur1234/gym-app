<?php

namespace App\Repositories\Message;

use App\Models\Message\Message;

class MessageRepository implements MessageRepositoryInterface
{
    public function getGlobalMessages()
    {
        return Message::whereNull('receiver_id')
            ->with('user')
            ->orderBy('created_at', 'asc') 
            ->get()
            ->append('time');
    }

    public function getPrivateMessages($userId, $receiverId)
    {
        return Message::where(function ($query) use ($userId, $receiverId) {
            $query->where('user_id', $userId)
                ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($userId, $receiverId) {
            $query->where('user_id', $receiverId)
                ->where('receiver_id', $userId);
        })->with('user', 'receiver')->get()->append('time');
    }

    public function getUserActiveChats($userId)
    {
        return Message::where('user_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['user', 'receiver'])
            ->distinct('receiver_id')
            ->get(['receiver_id'])
            ->map(function ($message) use ($userId) {
                return [
                    'id' => $message->receiver_id,
                    'name' => $message->receiver->name ?? 'Nieznany użytkownik', 
                ];
            });
    }

    public function sendMessage($data)
    {
        return Message::create([
            'user_id' => $data['user_id'],
            'text' => $data['text'],
            'time' => now(),
            'receiver_id' => $data['receiver_id'],
        ]);
    }
}
