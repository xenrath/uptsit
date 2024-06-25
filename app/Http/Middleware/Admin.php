<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if ($request->user()->isAdmin()) {
                return $next($request);
            } else {
                return redirect('check-user');
            }
        } else {
            return redirect('check-user');
        }
    }
}
