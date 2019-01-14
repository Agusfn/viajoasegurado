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



    public function index()
    {

        return view("front.home")->with([
            "countries_from" => ATV::getCountriesFrom(), 
            "regions_to" => ATV::getRegionsTo()
        ]);

    }


    public function support()
    {
        return view("front.support");
    }

    public function sendContactForm(Request $request)
    {
        
        $request->validate([
            "name" => "required|max:100",
            "email" => "required|email|max:100",
            "reason" => "required|in:inquire,inquire-contract,other",
            "message" => "required"
        ]);



        dd($request);
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





}
