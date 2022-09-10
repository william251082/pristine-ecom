<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;

class BuyerController extends ApiController
{
    public function index(): JsonResponse
    {
        $buyers = Buyer::has('transaction')->get();

        return response()->json(['data' => $buyers], 200);
    }

    public function show($id): JsonResponse
    {
        $buyer = Buyer::has('transaction')->findOrFail($id);

        return response()->json(['data' => $buyer], 200);
    }
}
