<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class BuyerProductController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Buyer $buyer): JsonResponse
    {
        $products = $buyer
            ->transaction()
            ->with('product')
            ->get()
            ->pluck('product')
        ;

        return $this->showAll($products);
    }
}
