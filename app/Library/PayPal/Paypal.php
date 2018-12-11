<?php

namespace App\Library\PayPal;

class Paypal
{


	const CLIENT_ID = "AXHLV6JfwUPJ42XieOsFkZuxNFpcDkrp5hwE2BhEcdEwBNI_JKV9dQcgaQ7l93CyqEXDiBdqxn16plo0";
	const CLIENT_SECRET = "EEkLivaZzpTPIuOLzYru-HtU0wqxi-0u9oUeTEjhwxbCoVK2DUbx61acXq7TiJxrZbYMzj49XLXQTaZ1";

	const CLIENT_ID_SANDBOX = "ATq0sqqUAvNQ8rKwbJioZwcqupg_z0GgVuVtqQIZ6T83AvEaggz54ZP8svBlP04n13LQKvc4DzQ-AIBT";
	const CLIENT_SECRET_SANDBOX = "EC2U9MVNN1AVzvLaIT_mNvxlK_NPfcghjZOnUVTD3Kg-_9OKZzoNqUhmPWxC9ZnHlh09pa7L9I8OTsJa";


	private $apiContext;


	public function __construct()
	{
        
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                (env("APP_ENV") == "production") ? self::CLIENT_ID : self::CLIENT_ID_SANDBOX,
                (env("APP_ENV") == "production") ? self::CLIENT_SECRET : self::CLIENT_SECRET_SANDBOX
            )
        );

	}


	public function createPayment(\App\PaypalRequest $ppRequest)
	{

        
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $item1 = new \PayPal\Api\Item(); 
        $item1->setName($ppRequest->item_title)
            ->setCurrency('USD')
            ->setQuantity($ppRequest->item_quantity)
            ->setPrice($ppRequest->item_unit_price);
       
        $itemList = new \PayPal\Api\ItemList();
        $itemList->setItems(array($item1));

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal(round($ppRequest->item_quantity * $ppRequest->item_unit_price, 2));
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


        
        try 
        {
            $payment->create($this->apiContext);

            dump($payment);

            return $payment;
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) 
        {
            echo $ex->getData();
            return false;
        }

	}




}