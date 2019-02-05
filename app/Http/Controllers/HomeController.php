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




    /**
     * Cambia configuracion de lenguaje en cookie y redirige a ruta pag ppal.
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function changeLanguage(Request $request)
    {
        
        if($request->has("code") && in_array($request->code, Config::get("app.langs")))
        {
            $cookie = cookie("lang", $request->code, 518400);
            return redirect('/')->withCookie($cookie);
        }
        return redirect('/');
    }



    /**
     * Muestra pagina inicio
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {

        return view("front.home")->with([
            "countries_from" => ATV::getCountriesFrom(), 
            "regions_to" => ATV::getRegionsTo()
        ]);

    }

    /**
     * Muestra pagina contacto
     * @return \Illuminate\Http\Response
     */
    public function support()
    {
        return view("front.support");
    }


    /**
     * Envia mail de formulario de contacto.
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function sendContactForm(Request $request)
    {
        
        $request->validate([
            "name" => "required|max:100",
            "email" => "required|email|max:100",
            "reason" => "required|in:inquire,inquire-contract,other",
            "message" => "required"
        ]);

        $mail = new App\Mail\Contact($request->name, $request->email, $request->reason, $request->contract_number, $request->message);
        \Mail::to("contacto@viajoasegurado.com")->send($mail);
        
        \Session::flash("success"); 
        return back();
    }


    /**
     * Muestra detalles de aseguradora
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function insurerDetails(Request $request)
    {
        $insurers = ["assist-card", "universal-assistance", "coris", "axa-assistance", "cardinal-assistance", "europ-assistance", "travel-ace", "assist-365", "latin-assistance", "international-assist", "euroamerican-assistance", "go-travel-assistance", "allianz-assistance"];

        if(in_array($request->insurer_name, $insurers)) 
            return view("front.insurers.es.".$request->insurer_name);
        else
            return redirect("");

    }


    /**
     * Muestra detalles de tipos de seguros
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function insuranceTypeDetails(Request $request)
    {
        $lang = App::getLocale();

        if($request->insurance_type == __("routes.longs_stay_student"))
            return view("front.insurance_types.".$lang.".longs_stay_student");

        else if($request->insurance_type == __("routes.multi_trip"))
            return view("front.insurance_types.".$lang.".multi_trip");

        else if($request->insurance_type == __("routes.it_insurance"))
            return view("front.insurance_types.".$lang.".it_insurance");

        else if($request->insurance_type == __("routes.sports_insurance"))
            return view("front.insurance_types.".$lang.".sports_insurance");

        else if($request->insurance_type == __("routes.cancellation_insurance"))
            return view("front.insurance_types.".$lang.".cancellation_insurance");

        else if($request->insurance_type == __("routes.chronic_disease_senior_insurance"))
            return view("front.insurance_types.".$lang.".chronic_disease_senior_insurance");

        else if($request->insurance_type == __("routes.pregnant_insurance"))
            return view("front.insurance_types.".$lang.".pregnant_insurance");

        else
            return redirect("");
    }



    /**
     * Muestra pag acerca de
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {
        return view("front.about");
    }


    /**
     * Muestra términos y condiciones
     * @return [type] [description]
     */
    public function showTermsAndConditions()
    {
        if(App::getLocale() == "en")
            return view("front.terms_and_conditions_en");
        else
            return view("front.terms_and_conditions_es");
    }






}
