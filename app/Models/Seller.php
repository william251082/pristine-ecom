<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends User
{
    protected $table = 'user';

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
