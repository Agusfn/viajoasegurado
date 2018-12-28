<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use \Config;
use App\Library\AseguratuViaje\ATV;



class HomeController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('check_language', ['only' => ['index']]);
    }



    public function searchdemo()
    {
        return view("front.searchdemo");
    }

    public function index()
    {

        return view("front.home")->with([
            "countries_from" => ATV::getCountriesFrom(), 
            "regions_to" => ATV::getRegionsTo()
        ]);

    }



    public function changeLanguage(Request $request)
    {
        
        if($request->has("code") && in_array($request->code, Config::get("app.langs")))
        {
            $cookie = cookie("lang", $request->code, 518400);
            return redirect('/')->withCookie($cookie);
        }
        return redirect('/');
    }


    /*public function contact()
    {
        return "Página de contacto!! Lenguaje: ".App::getLocale();
    }*/


}
