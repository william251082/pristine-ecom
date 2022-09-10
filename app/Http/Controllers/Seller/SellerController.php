<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\JsonResponse;

class SellerController extends ApiController
{
    public function index(): JsonResponse
    {
        $sellers = Seller::has('product')->get();

        return response()->json(['data' => $sellers], 200);
    }

    public function show($id): JsonResponse
    {
        $seller = Seller::has('product')->findOrFail($id);

        return response()->json(['data' => $seller], 200);
    }
}
