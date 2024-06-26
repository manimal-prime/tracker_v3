<?php

namespace App\Http\Middleware;

use Closure;

class IsBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::check() && $request->user()->role_id === 6) {
            abort(403, 'You are banned.');
        }

        return $next($request);
    }
}
