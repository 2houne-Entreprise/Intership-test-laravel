<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->session()->get('locale'), ['fr', 'en'], true)) {
            app()->setLocale($request->session()->get('locale'));
        }

        return $next($request);
    }
}
