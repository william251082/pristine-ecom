<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class ProductTransactionController extends ApiController
{
    use ApiResponser;

    public function index(Product $product): JsonResponse
    {
        $transactions = $product->transactions()->get();

        return $this->showAll($transactions);
    }
}
