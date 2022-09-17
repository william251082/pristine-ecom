<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class ProductController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
    }

    public function index(): JsonResponse
    {
        $products = Product::all();

        return $this->showAll($products);
    }

    public function show(Product $product): JsonResponse
    {
        return $this->showOne($product);
    }
}
