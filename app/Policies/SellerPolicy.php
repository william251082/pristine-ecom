<?php

namespace App\Policies;

use App\Models\Seller;
use App\Models\User;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
    use HandlesAuthorization, AdminActions;

    public function view(User $user, Seller $seller): bool
    {
        return $user->id === $seller->id;
    }

    public function sale(User $user, User $seller): bool
    {
        return $user->id === $seller->id;
    }

    public function editProduct(User $user, Seller $seller): bool
    {
        return $user->id === $seller->id;
    }

    public function deleteProduct(User $user, Seller $seller): bool
    {
        return $user->id === $seller->id;
    }
}
