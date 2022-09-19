<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class TransactionSellerController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
    }

    public function index(Transaction $transaction): JsonResponse
    {
        $seller = $transaction->product->seller;

        return $this->showOne($seller);
    }
}
