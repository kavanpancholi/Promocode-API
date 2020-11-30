<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class ResponseCacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->method() === 'GET') {
            $key = 'request|' . $request->url();
            return Cache::remember($key, 60, function () use ($request, $next) {
                return $next($request);
            });
        }
        return $next($request);
    }
}
