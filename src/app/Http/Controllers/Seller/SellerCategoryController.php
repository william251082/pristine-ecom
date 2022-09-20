<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;

class SellerCategoryController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
        $this->middleware('can:view,seller')->only('index');
    }

    public function index(Seller $seller): JsonResponse
    {
        $categories = $seller
            ->product()
            ->whereHas('categories')
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique('id')
            ->values()
        ;

        return $this->showAll($categories);
    }
}
