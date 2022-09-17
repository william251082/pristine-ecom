<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait ApiResponser
{
    private function successResponse(array $data, int $code): JsonResponse
    {
        return response()->json($data, $code);
    }

    private function errorResponse(string|array $message, int $code): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200): JsonResponse
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        $transformer = $collection->first()->transformer;
        $collection = $this->sortData($collection);
        $collection = $this->transformData($collection, $transformer);

        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200): JsonResponse
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }

    protected function showMessage(string $message, $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function sortData(Collection $collection): Collection
    {
        if (request()->has('sort_by')) {
            $attribute = request()->sort_by;

            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    protected function transformData(Collection|Model $data, $transformer): array
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }
}
