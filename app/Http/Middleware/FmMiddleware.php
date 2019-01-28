<?php

namespace App\Http\Middleware;

use Closure;

class fmMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Authorization', 'key=AIzaSyBJq800ZEsQ7NX4sfFvZoMFmSRUykBz0Fs');
        $response->header('Content-Type', 'application/json');
        return $response;
    }
}
