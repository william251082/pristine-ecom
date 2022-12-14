<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization, AdminActions;

    public function view(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->id === $user->id;
    }

    public function update(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->id === $user->id;
    }

    public function delete(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->id === $user->id;
//            && $authenticatedUser->token()->client()->personal_access_client;
    }
}
