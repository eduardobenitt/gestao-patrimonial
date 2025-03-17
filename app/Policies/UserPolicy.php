<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authUser): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $authUser = null, User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $authUser = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $user): bool
    {
        if ($authUser->isAdmin()) {
            return true;
        }

        if ($authUser->isTecnico() && $user->role !== 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, User $user): bool
    {
        return $authUser->isAdmin();
    }


    public function promover(User $authUser, User $user)
    {

        return $authUser->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $authUser, User $user): bool
    {
        return $authUser->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $authUser, User $user): bool
    {
        return $authUser->isAdmin();
    }
}
