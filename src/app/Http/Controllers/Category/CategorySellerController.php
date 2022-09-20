<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class CategorySellerController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Category $category): JsonResponse
    {
        $this->allowedAdminAction();
        $sellers = $category
            ->products()
            ->with('seller')
            ->get()
            ->pluck('seller')
            ->unique('id')
            ->values()
        ;

        return $this->showAll($sellers);
    }
}
