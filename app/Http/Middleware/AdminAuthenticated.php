<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard("adminMiddle")->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response("Unauthorized.", 401);
            } else {
                return abort(404);
            }
        }
        return $next($request);
    }
}
