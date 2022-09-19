<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class BuyerTransactionController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
    }

    public function index(Buyer $buyer): JsonResponse
    {
        $transactions = $buyer->transaction;

        return $this->showAll($transactions);
    }
}
