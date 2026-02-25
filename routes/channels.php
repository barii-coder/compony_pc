<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('notifications.admins', function ($user) {
    // فقط کاربران با نقش admin اجازه گوش دادن دارند
    return $user->role === 'admin';
});

Broadcast::channel('admins', function ($user) {
    return true;
});

