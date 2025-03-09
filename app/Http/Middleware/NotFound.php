<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotFound
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route() === null) {
            return response()->json([
                'is_error' => true,
                'error' => 'Route not found',
                'status_code' => 404,
                'error_code' => 404,
            ], 404);
        }
        return $next($request);
    }
}
