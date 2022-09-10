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

    private function errorResponse(string $message, int $code): JsonResponse
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $model, $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $model], $code);
    }
}
