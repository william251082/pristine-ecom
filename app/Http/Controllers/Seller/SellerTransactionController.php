<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class SellerTransactionController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Seller $seller): JsonResponse
    {
        $transactions = $seller
            ->product()
            ->whereHas('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse()
        ;

        return $this->showAll($transactions);
    }
}
