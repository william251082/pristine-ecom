<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class TransactionSellerController extends Controller
{
    use ApiResponser;

    public function index(Transaction $transaction): JsonResponse
    {
        $seller = $transaction->product->seller;

        return $this->showOne($seller);
    }
}
