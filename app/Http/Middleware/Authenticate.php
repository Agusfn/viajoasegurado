<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        if(\Auth::user()->isDisabled())
        {
            \Auth::logout();
            $request->session()->invalidate();    
            throw new AuthenticationException(
                'Unauthenticated.', $guards, $this->redirectTo($request)
            );
        }

        \Auth::user()->updateActivity();

        return $next($request);
    }



    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * Redirige si se entra a alguna página protegida sin estar logueado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }



}
