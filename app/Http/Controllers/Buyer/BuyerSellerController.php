<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class BuyerSellerController extends Controller
{
    use ApiResponser;

    public function index(Buyer $buyer): JsonResponse
    {
        $sellers = $buyer
            ->transaction()
            ->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values()
        ;

        return $this->showAll($sellers);
    }
}
