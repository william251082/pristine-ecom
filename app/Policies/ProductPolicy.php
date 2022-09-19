<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function addCategory(User $user, Product $product): bool
    {
        return $user->id === $product->seller->id;
    }

    public function deleteCategory(User $user, Product $product): bool
    {
        return $user->id === $product->seller->id;
    }
}
