<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $expires_after = Carbon::now()->addSeconds(2);
            Cache::put("user-online" . Auth::user()->id, true, $expires_after);

            /* last seen */
            User::where("id", Auth::user()->id)->update(["last_seen" => now()]);
        }
        return $next($request);
    }
}
