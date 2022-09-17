<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class TransactionCategoryController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }

    public function index(Transaction $transaction): JsonResponse
    {
        $categories = $transaction->product->categories;

        return $this->showAll($categories);
    }
}
