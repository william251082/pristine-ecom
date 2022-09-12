<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class CategoryProductController extends ApiController
{
    use ApiResponser;

    public function index(Category $category): JsonResponse
    {
        $products = $category->products;

        return $this->showAll($products);
    }
}
