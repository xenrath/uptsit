<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cbt
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if ($request->user()->isCbt()) {
                return $next($request);
            } else {
                abort('404');
            }
        } else {
            return redirect('check-user');
        }
    }
}
