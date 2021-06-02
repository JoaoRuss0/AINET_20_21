<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class IsBloqueado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && Auth::user()->bloqueado != 1)
        {
            return $next($request);
        }

        Auth::logout();

        return redirect()->route('login')
            ->with('title', "Login")
            ->with('message', "You have been blocked!")
            ->with('message_type', "message_error");
    }
}
