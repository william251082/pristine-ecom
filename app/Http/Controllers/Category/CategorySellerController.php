<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class CategorySellerController extends ApiController
{
    use ApiResponser;

    public function index(Category $category): JsonResponse
    {
        $sellers = $category
            ->products()
            ->with('seller')
            ->get()
            ->pluck('seller')
            ->unique('id')
            ->values()
        ;

        return $this->showAll($sellers);
    }
}
