<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Traits\ApiResponser;
use App\Transformers\CategoryTransformer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:'.CategoryTransformer::class)->only(['store', 'update']);
    }

    public function index(): JsonResponse
    {
        $categories = Category::all();

        return $this->showAll($categories);
    }

    /**
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->allowedAdminAction();
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];
        $this->validate($request, $rules);

        $newCategory = Category::create($request->all());

        return $this->showOne($newCategory, 201);
    }

    public function show(Category $category): JsonResponse
    {
        return $this->showOne($category);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $this->allowedAdminAction();
        $category->fill($request->only([
            'name',
            'description'
        ]));
        if ($category->isClean()) {
            return $this->errorResponse('You need to specify any different value to update', 422);
        }
        $category->save();

        return $this->showOne($category);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->allowedAdminAction();
        $category->delete();

        return $this->showOne($category);
    }
}
