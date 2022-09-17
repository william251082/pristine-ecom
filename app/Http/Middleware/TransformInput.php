<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use League\Fractal\TransformerAbstract;

class TransformInput
{
    public function handle(Request $request, Closure $next, TransformerAbstract|string $transformer)
    {
        $transformedInput = [];

        foreach ($request->request->all() as $input => $value) {
            $transformedInput[$transformer::originalAttribute($input)] = $value;
        }
        $request->replace($transformedInput);
        $response = $next($request);

        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();

            $transformedErrors = [];
            foreach ($data->error as $field => $error) {
                $transformedField = $transformer::transformedAttribute($field);
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }

            $data->error = $transformedErrors;
            $response->setData($data);
        }

        return $response;
    }
}
