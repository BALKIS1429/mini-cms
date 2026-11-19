<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function changeRole(User $admin, User $target): bool
    {
        return $admin->isAdmin() && $admin->id !== $target->id;
    }
}
