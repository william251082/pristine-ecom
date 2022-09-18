<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class CategoryTransactionController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Category $category): JsonResponse
    {
        $transactions = $category
            ->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->unique('id')
            ->values()
        ;

        return $this->showAll($transactions);
    }
}
