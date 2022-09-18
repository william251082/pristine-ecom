<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class TransactionController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(): JsonResponse
    {
        $transactions = Transaction::all();

        return $this->showAll($transactions);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return $this->showOne($transaction);
    }
}
