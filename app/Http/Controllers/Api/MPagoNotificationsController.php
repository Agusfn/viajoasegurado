<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \App\Contract;
use \App\PaymentRequest; 
use \App\MercadoPagoRequest;

use App\Library\MercadoPago\MP;
use \MercadoPago\MerchantOrder;
use \MercadoPago\Payment;

class MPagoNotificationsController extends Controller
{
    

	public function __construct()
	{
		MP::APIAuth();
	}


	public function paymentUpdate(Request $request)
	{

		if(!$request->filled(["id", "topic"]) || $request->topic != "payment")
			return $this->error("Bad request.");



		$payment = Payment::find_by_id($request->id);
		
		if($payment->id == null)
			return $this->error("Payment resource not found.", 404);


		if($payment->status != "approved") // no proporciona información de un pago acreditado.
			return response("Not an approved payment notification.", 200);



		$merchantOrder = MerchantOrder::find_by_id($payment->order->id);

		if($merchantOrder->id == null)
			return $this->error("Merchant Order resource not found.", 404);



		$mpRequest = MercadoPagoRequest::findByPreferenceId($merchantOrder->preference_id);

		if($mpRequest == null)
			return $this->error("MpRequest resource not found.", 404);


		$paymentRequest = $mpRequest->parentRequest;


		if($paymentRequest->status == PaymentRequest::STATUS_APPROVED) // Si ya había sido marcado como aprobado.
			return response("Payment already marked as paid out.", 200);


		$mpRequest->markAsPaidOut(
			$merchantOrder->id, 
			$payment->id, 
			$payment->payment_method_id,
			date("Y-m-d H:i:s", strtotime($payment->date_approved)),
			$payment->fee_details[0]->amount
		);
		
		$paymentRequest->contract->changeStatus(Contract::STATUS_PROCESSING);



		return response("Payment marked as paid.", 200);		
	}



	public function error($msg = "", $code = 400)
	{
		\Log::warning("MercadoPago IPN error: " . $msg);
		return response($msg, $code);
	}

}
