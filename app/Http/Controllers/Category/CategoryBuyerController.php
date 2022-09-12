<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class CategoryBuyerController extends ApiController
{
    use ApiResponser;

    public function index(Category $category): JsonResponse
    {
        $buyers = $category
            ->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique('id')
            ->values()
        ;

        return $this->showAll($buyers);
    }
}
