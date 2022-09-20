<?php

namespace App\Models;

use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends User
{
    use SoftDeletes;

    public string $transformer = SellerTransformer::class;
    protected $table = 'user';
    protected $dates = ['deleted_at'];

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
