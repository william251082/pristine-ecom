<?php

namespace App\Models;

use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends User
{
    protected $table = 'user';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
