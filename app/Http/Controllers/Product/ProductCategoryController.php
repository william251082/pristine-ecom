<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('api.auth')->except(['index']);
        $this->middleware('scope:manage-products')->except('index');
    }

    public function index(Product $product): JsonResponse
    {
        $buyers = $product->categories()->get();

        return $this->showAll($buyers);
    }

    public function update(Request $request, Product $product, Category $category)
    {
        // methods for interacting on many to many: attach, sync, syncWithoutDetaching
        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories);
    }

    public function destroy(Product $product, Category $category): JsonResponse
    {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('Specified category is not of this product.', 404);
        }
        $product->categories()->detach($category->id);

        return $this->showAll($product->categories);
    }
}
