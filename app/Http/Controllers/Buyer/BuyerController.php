<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class BuyerController extends ApiController
{
    use ApiResponser;

    public function index(): JsonResponse
    {
        $buyers = Buyer::has('transaction')->get();

        return $this->showAll($buyers);
    }

    public function show($id): JsonResponse
    {
        $buyer = Buyer::has('transaction')->findOrFail($id);

        return $this->showOne($buyer);
    }
}
