<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class BuyerCategoryController extends Controller
{
    use ApiResponser;

    public function index(Buyer $buyer): JsonResponse
    {
        $transactions = $buyer
            ->transaction()
            ->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse()
            ->unique('id')
            ->values()
        ;

        return $this->showAll($transactions);
    }
}
