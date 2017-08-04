<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->guest('/login');
        }

        if (! $user->can($request->route()->getName())) {
            abort(403);
        }

        return $next($request);
    }
}
