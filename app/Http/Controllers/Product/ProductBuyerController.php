<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class ProductBuyerController extends ApiController
{
    use ApiResponser;

    public function index(Product $product): JsonResponse
    {
        $buyers = $product
            ->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique('id')
            ->values()
        ;

        return $this->showAll($buyers);
    }
}
