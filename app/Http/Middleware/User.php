<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class User
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if ($request->user()->isUser()) {
                return $next($request);
            } else {
                return redirect('check-user');
            }
        } else {
            return redirect('check-user');
        }
    }
}
