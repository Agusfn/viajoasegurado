<?php

namespace App\Http\Middleware;

use Closure;
use \Request;
use \Config;

class CheckLanguage
{
    /**
     * Redirige usuarios que llegan a la página principal sin prefijo de lenguaje a la página con lenguaje correspondiente.
     * Si tienen cookie de lenguaje válida, redirige a la pag ppal de ese lenguaje.
     * Si no tienen cookie, redirige al lenguaje del navegador (si es valido)
     * Si ninguna de las anteriores, sigue con el lenguaje default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if(Request::segment(1) == null) // Si la URL no especifica lenguaje. (Sólo para index)
        {

            $default_lang = \App::getLocale(); // default: es


            $saved_lang = \Cookie::get("lang");

            if($saved_lang != null && in_array($saved_lang, Config::get("app.langs")))
            {
                if($saved_lang == $default_lang)
                    return $next($request);
                else
                    return redirect($saved_lang);
            }
 
 
            $browser_lang = Request::getPreferredLanguage();
            $browser_lang = explode("_", $browser_lang)[0];

            if($browser_lang != $default_lang && in_array($browser_lang, Config::get("app.langs")))
            {
                return redirect($browser_lang);
            }

        }
    

        return $next($request);
    }
}
