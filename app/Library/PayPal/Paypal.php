<?php

namespace App\Library\PayPal;

use \App\PaypalRequest;

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
                (config("app.env") == "production") ? self::CLIENT_ID : self::CLIENT_ID_SANDBOX,
                (config("app.env") == "production") ? self::CLIENT_SECRET : self::CLIENT_SECRET_SANDBOX
            )
        );

	}


	public function createPayment(PaypalRequest $ppRequest)
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
        $redirectUrls->setReturnUrl(config("app.url")."/contract/payment/paypal")
            ->setCancelUrl(config("app.url")."/contract/payment/paypal");

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);


        
        try 
        {
            $payment->create($this->apiContext);

            return $payment;
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) 
        {
            echo $ex->getData();
            return false;
        }

	}

    /**
     * Ejecuta y concreta un pago de PayPal ya preparado.
     * @param  string $paymentId    Id de pago de PayPal
     * @param  string $payerId      Id de payer de PayPal
     * @return \PayPal\Api\Payment | false
     */
    public function executePayment($paymentId, $payerId)
    {
            
        $payment = $this->getPaymentById($paymentId);

        if(!$payment)
            return false;


        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($payerId);
        
        try {
            $result = $payment->execute($execution, $this->apiContext);
        } 
        catch (\Exception $ex) 
        {
            //dump("Executed Payment", "Payment", null, null, $ex);
            return false;
        }

        return $this->getPaymentById($paymentId);
    }


    /**
     * [getPaymentById description]
     * @param  [type] $paymentId [description]
     * @return [type]            [description]
     */
    public function getPaymentById($paymentId)
    {
        try 
        {
            $payment = \PayPal\Api\Payment::get($paymentId, $this->apiContext);
            return $payment;
        } 
        catch (\Exception $ex) 
        {
            //dump("Executed Payment", "Payment", null, null, $ex);
            return false;
        } 
    }


    


}