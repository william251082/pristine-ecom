<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

        return $next($request);
    }
}
