<?php

namespace App\Repositories\Message;

interface MessageRepositoryInterface
{
    public function getGlobalMessages();
    public function getPrivateMessages($userId, $receiverId);
    public function getUserActiveChats($userId);
    public function sendMessage($data);
}
