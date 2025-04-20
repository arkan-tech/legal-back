<?php

namespace App\Http\Middleware;

use Inertia\Inertia;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Store the intended URL in the session
            $request->session()->put('url.intended', $request->url());
            return Inertia::render('Authentication/SignIn');
        }
    }
}
