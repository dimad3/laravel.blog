<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::user() && Auth::user()->is_admin === 1) {
            return $next($request);
        }
        /**
         * vendor\laravel\framework\src\Illuminate\Foundation\helpers.php
         *
         * function abort($code, $message = '', array $headers = [])
         *
         * Throws an HTTPexception with the given data which will be rendered by the exception handler
         *
         * @param  \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable|int  $code
         * @param  string  $message
         * @param  array  $headers
         * @return void
         *
         * @throws \Symfony\Component\HttpKernel\Exception\HttpException
         * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
         */
        return abort(404);
    }
}
