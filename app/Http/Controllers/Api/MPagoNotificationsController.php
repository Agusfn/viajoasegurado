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


		$merchantOrder = MerchantOrder::find_by_id($payment->order->id);

		if($merchantOrder->id == null)
			return $this->error("Merchant Order resource not found.", 404);


		$mpRequest = MercadoPagoRequest::findByPreferenceId($merchantOrder->preference_id);

		if($mpRequest == null)
			return $this->error("MpRequest resource not found.", 404);

		$paymentRequest = $mpRequest->parentRequest;


		if(in_array($paymentRequest->status, [PaymentRequest::STATUS_APPROVED, PaymentRequest::STATUS_FAILED, PaymentRequest::STATUS_REFUNDED]))
			return response("Payment can't change its status, already changed.", 200);
	

		if($payment->status == "approved")
		{
			
			$mpRequest->markAsPaidOut(
				$merchantOrder->id, 
				$payment->id, 
				$payment->payment_method_id,
				date("Y-m-d H:i:s", strtotime($payment->date_approved)),
				$payment->fee_details[0]->amount
			);

			$paymentRequest->contract->changeStatus(Contract::STATUS_PROCESSING);
		}
		else if($payment->status == "rejected")
		{
			$paymentRequest->markAsFailed();
			$paymentRequest->contract->changeStatus(Contract::STATUS_CANCELED_ERROR_PAYMENT);
		}
		else
			return response("Not a relevant payment notification.", 200);


		return response("Payment updated successfully.", 200);
	}



	public function error($msg = "", $code = 400)
	{
		\Log::warning("MercadoPago IPN error: " . $msg);
		return response($msg, $code);
	}

}
