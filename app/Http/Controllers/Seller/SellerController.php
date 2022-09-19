<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class SellerController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('show');
    }

    public function index(): JsonResponse
    {
        $sellers = Seller::has('product')->get();

        return $this->showAll($sellers);
    }

    public function show(Seller $seller): JsonResponse
    {
        return $this->showOne($seller);
    }
}
