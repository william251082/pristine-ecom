<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class SellerBuyerController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Seller $seller): JsonResponse
    {
        $buyers = $seller
            ->product()
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
