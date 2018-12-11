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



    public function index()
    {

        $countries_from = Config::get("custom.insurances.countries_from");
        $regions_to = Config::get("custom.insurances.regions_to");


        if(!App::isLocale("en")) // paises y regiones vienen en ingles
        {
            
            for($i=0; $i<sizeof($countries_from); $i++)
            {
                $countries_from[$i]["name"] = __($countries_from[$i]["name"]);
            }

            for($i=0; $i<sizeof($regions_to); $i++)
            {
                $regions_to[$i]["name"] = __($regions_to[$i]["name"]);
            }

        }


        usort($countries_from, function ($item1, $item2) {
            return $item1['name'] <=> $item2['name'];
        });


        return view("frontoffice.home")->with([
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


    public function asdf()
    {
        


        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'ATq0sqqUAvNQ8rKwbJioZwcqupg_z0GgVuVtqQIZ6T83AvEaggz54ZP8svBlP04n13LQKvc4DzQ-AIBT',     // ClientID
                'EC2U9MVNN1AVzvLaIT_mNvxlK_NPfcghjZOnUVTD3Kg-_9OKZzoNqUhmPWxC9ZnHlh09pa7L9I8OTsJa'      // ClientSecret
            )
        );


        // After Step 2
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $item1 = new \PayPal\Api\Item(); 
        $item1->setName('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice(7.5);
       
        $itemList = new \PayPal\Api\ItemList();
        $itemList->setItems(array($item1));

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal(7.5);
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount)->setItemList($itemList);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl("https://example.com/your_redirect_url.html")
            ->setCancelUrl("https://example.com/your_cancel_url.html");

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);


        // After Step 3
        try {
            $payment->create($apiContext);
            dump($payment);

            echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }



        return "asdf";
    }

    /*public function contact()
    {
        return "Página de contacto!! Lenguaje: ".App::getLocale();
    }*/


}
