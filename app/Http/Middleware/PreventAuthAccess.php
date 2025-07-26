<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAuthAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        if (
            str_starts_with($path, "auth/") &&
            !in_array($path, [
                "auth/facebook",
                "auth/google",
                "auth/twitter",
            ]) &&
            !str_starts_with($path, "auth/activate/")
        ) {
            abort(403);
        }

        return $next($request);
    }
}
