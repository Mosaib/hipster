<?php
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes([
    'middleware' => ['web', 'auth:customer'],
]);

Broadcast::channel('orders.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId && $user->user_type === 'customer';
});

// Broadcast::channel('online-users', function ($user) {
//     return ['id' => $user->id, 'name' => $user->name, 'user_type' => $user->user_type];
// });

