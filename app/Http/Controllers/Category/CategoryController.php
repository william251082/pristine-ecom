<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Traits\ApiResponser;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('transform.input:'.CategoryTransformer::class)->only(['store', 'update']);
    }

    public function index(): JsonResponse
    {
        $categories = Category::all();

        return $this->showAll($categories);
    }

    public function store(Request $request): JsonResponse
    {
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

    public function update(Request $request, Category $category): JsonResponse
    {
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

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return $this->showOne($category);
    }
}
