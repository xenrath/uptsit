<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Support
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if ($request->user()->isSupport()) {
                return $next($request);
            } else {
                abort('404');
            }
        } else {
            return redirect('check-user');
        }
    }
}
