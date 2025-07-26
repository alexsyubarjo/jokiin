<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = User::find(Auth::id());

        if ($user && $user->role == $role) {
            return $next($request);
        }

        return redirect()
            ->route("dashboard")
            ->with("error", "Silahkan Ganti Mode");
    }
}
