<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

       
        if ($request->user()->role !== $role) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}



