<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ProductBuyerController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Product $product): JsonResponse
    {
        $this->allowedAdminAction();
        $buyers = $product
            ->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique('id')
            ->values()
        ;

        return $this->showAll($buyers);
    }
}
