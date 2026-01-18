<?php

use App\Enums\EnumsRoles;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('admin-notifications', function ($user) {
    return $user->role === EnumsRoles::ADMIN;
});
