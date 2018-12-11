<?php

namespace App\Http\Middleware;

use Closure;
use \Request;
use \Config;

class CheckLanguage
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
        
        if(Request::segment(1) == null) // Si la URL no especifica lenguaje. (Sólo para index)
        {

            $lang = \App::getLocale(); // default=es


            $cookie_lang = \Cookie::get("lang");

            if($cookie_lang != null && $cookie_lang != $lang)
            {
                return redirect($cookie_lang);
            }

            $browser_lang = Request::getPreferredLanguage();
            $browser_lang = explode("_", $browser_lang)[0];

            if($browser_lang != $lang && in_array($browser_lang, Config::get("app.langs")))
            {
                return redirect($browser_lang);
            }

        }
    

        return $next($request); // Sigue lenguaje default=español
    }
}
