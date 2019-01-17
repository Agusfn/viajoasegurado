<?php

namespace App\Library\PayPal;

use \App\PaypalRequest;

class Paypal
{


	const CLIENT_ID = "AXHLV6JfwUPJ42XieOsFkZuxNFpcDkrp5hwE2BhEcdEwBNI_JKV9dQcgaQ7l93CyqEXDiBdqxn16plo0"; // cuenta admin@viajoasegurado.com
	const CLIENT_SECRET = "EEkLivaZzpTPIuOLzYru-HtU0wqxi-0u9oUeTEjhwxbCoVK2DUbx61acXq7TiJxrZbYMzj49XLXQTaZ1";

	const CLIENT_ID_SANDBOX = "ATq0sqqUAvNQ8rKwbJioZwcqupg_z0GgVuVtqQIZ6T83AvEaggz54ZP8svBlP04n13LQKvc4DzQ-AIBT"; // cuenta test admin-facilitator@viajoasegurado.com
	const CLIENT_SECRET_SANDBOX = "EC2U9MVNN1AVzvLaIT_mNvxlK_NPfcghjZOnUVTD3Kg-_9OKZzoNqUhmPWxC9ZnHlh09pa7L9I8OTsJa";


	private $apiContext;

    /**
     * Autentifica en API
     */
	public function __construct()
	{
        
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                (config("app.env") == "production") ? self::CLIENT_ID : self::CLIENT_ID_SANDBOX,
                (config("app.env") == "production") ? self::CLIENT_SECRET : self::CLIENT_SECRET_SANDBOX
            )
        );

	}

    /**
     * Crea pago PayPal por medio del SDK (envia solicitud a api paypal)
     * @param  PaypalRequest $ppRequest
     * @return \PayPal\Api\Payment | false
     */
	public function createPayment(PaypalRequest $ppRequest, $contract_number)
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
        $transaction->setAmount($amount)->setItemList($itemList)->setCustom("#".$contract_number);

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
            \Log::notice("Error creando Payment de PayPal: ".$ex->getMessage());
            return false;
        }

	}

    /**
     * Ejecuta un pago de PayPal ya preparado.
     * @param  string $paymentId    Id de pago de PayPal
     * @param  string $payerId      Id de payer de PayPal
     * @return \PayPal\Api\Payment | false      Aparentemente sólo devuelve false si hay un problema con la solicitud. Si el pago falla o es exitoso devuelve Payment.
     */
    public function executePayment($paymentId, $payerId)
    {
            
        $payment = $this->getPaymentById($paymentId);

        if(!$payment)
            return false;


        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($payerId);
        
        try {
            $payment->execute($execution, $this->apiContext); // instancia de Payment
        } 
        catch (\Exception $ex) 
        {
            \Log::notice("Error ejecutando pago PayPal (Payment id ".$paymentId.", Payer id ".$payerId."). Mensaje: ".$ex->getMessage().".".PHP_EOL ."Data: ".$ex->getData());
            return false;
        }

        return $this->getPaymentById($paymentId); // Lo volvemos a obtener porque tiene más datos
    }


    /**
     * Obtiene Payment desde api PayPal (usando sdk)
     * @param  int $paymentId   id de pago
     * @return \PayPal\Api\Payment | false
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
            \Log::notice("Error obtiendo datos de pago PayPal (Payment id ".$paymentId."). Mensaje: ".$ex->getMessage());
            return false;
        } 
    }


    


}