<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocaleMiddleware
{
    public function handle($request, Closure $next)
    {
        // Set the application's locale to 'en' (English) or any other desired locale
        App::setLocale('en');

        return $next($request);
    }
}