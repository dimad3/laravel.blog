<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /**
         * Illuminate\Support\Facades\Auth::guard
         *
         * public static function guard($name = null) { }
         *
         * At its core, Laravel's authentication facilities are made up of "guards" and "providers".
         * Guards define how users are authenticated for each request.
         * For example, Laravel ships with a session guard which maintains state using session storage and cookies.
         *
         * @param  @param string|null $name
         *
         * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
         */
        if (Auth::guard($guard)->check()) {
            /**
             * vendor\laravel\framework\src\Illuminate\Routing\Redirector.php
             *
             * public function home($status = 302)
             *
             * Create a new redirect response to the "home" nemed-route.
             *
             * @param  int  $status
             * @return \Illuminate\Http\RedirectResponse
             */
            return redirect()->home();
        }

        return $next($request);
    }
}
