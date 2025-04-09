<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ProfileJsonResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        //check if debug bar is enable
        if (! app()->bound('debugbar')) {
            return $response;
        }

        //profile the json response
        if ($response instanceof Response && $request->hasHeader('Is-Debug') && ! $response instanceof RedirectResponse) {
            $response->setData([
                '_debugbar' => Arr::only(app('debugbar')->getData(), 'queries'),
            ] + $response->getData(true));
        }

        return $response;
    }
}
