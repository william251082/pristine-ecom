<?php

namespace App\Traits;

use App\Models\User;
use JetBrains\PhpStorm\Pure;

trait AdminActions
{
    #[Pure]
    public function before(User $user): null|bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }
}
