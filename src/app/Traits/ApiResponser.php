<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use League\Fractal\TransformerAbstract;

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
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);

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

    protected function paginate(Collection $collection): LengthAwarePaginator
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        if (request()->has('per_page')) {
            $perPage = (int)request()->per_page;
        }
        $results = $collection->slice(($page-1)*$perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function filterData(Collection $collection, TransformerAbstract|string $transformer): Collection
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::originalAttribute($query);

            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;
    }

    protected function sortData(Collection $collection, TransformerAbstract|string $transformer): Collection
    {
        if (request()->has('sort_by')) {
            $attribute = $transformer::originalAttribute(request()->sort_by);

            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    protected function transformData(Collection|Model|LengthAwarePaginator $data, $transformer): array
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }
    protected function cacheResponse(array $collection): array
    {
        $url = request()->url();
        $queryParams = request()->query();
        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30, function() use($collection) {
            return $collection;
        });
    }
}
