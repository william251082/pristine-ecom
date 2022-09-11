<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends User
{
    protected $table = 'user';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
