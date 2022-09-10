<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends User
{
    protected $table = 'user';

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
