<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('last_activity') && time() - session('last_activity') > 3600) {
            auth()->logout();
            return redirect()->route('login')->with('message', 'Session expired');
        }

        session(['last_activity' => time()]);
        return $next($request);
    }
}
