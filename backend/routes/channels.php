<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('private-channel.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('channel-for-everyone', function ($user) {
    return true;
});