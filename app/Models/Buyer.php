<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends User
{
    use SoftDeletes;

    public string $transformer = BuyerTransformer::class;
    protected $table = 'user';
    protected $dates = ['deleted_at'];

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
