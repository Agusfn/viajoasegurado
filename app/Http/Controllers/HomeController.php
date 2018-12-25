<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App;
use \Config;

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


        $countries_from = Config::get("custom.insurances.countries_from");
        $regions_to = Config::get("custom.insurances.regions_to"); // paises y regiones vienen en ingles


        if(!App::isLocale("en"))
        {
            
            for($i=0; $i<sizeof($countries_from); $i++) {
                $countries_from[$i]["name"] = __($countries_from[$i]["name"]);
            }

            for($i=0; $i<sizeof($regions_to); $i++) {
                $regions_to[$i]["name"] = __($regions_to[$i]["name"]);
            }

        }


        usort($countries_from, function ($item1, $item2) {
            return $item1['name'] <=> $item2['name'];
        });


        return view("front.home2")->with([
            "countries_from" => $countries_from, 
            "regions_to" => $regions_to
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
