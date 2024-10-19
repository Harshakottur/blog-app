<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any users.
     */
    public function viewAny(User $user)
    {
        return $user->is_admin; // Only admins can view users
    }

    /**
     * Determine whether the user can delete a user.
     */
    public function delete(User $user)
    {
        return $user->is_admin; // Only admins can delete users
    }
}
