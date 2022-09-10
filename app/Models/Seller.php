<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends User
{
    protected $table = 'seller';

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
