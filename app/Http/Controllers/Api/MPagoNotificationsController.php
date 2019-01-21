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
    
	/**
	 * Autentifica con API Mercadopago
	 */
	public function __construct()
	{
		MP::APIAuth();
	}


	/**
	 * Procesa solicitud de IPN mercadopago y actualiza el estado del pago.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
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



		if($paymentRequest->status == PaymentRequest::STATUS_UNPAID || $paymentRequest->status == PaymentRequest::STATUS_PROCESSING)
		{
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
			else if($payment->status == "in_process")
			{
				$mpRequest->markAsProcessing($request->collection_id);
			}
			else if($payment->status == "rejected")
			{
				$paymentRequest->markAsFailed();
				$paymentRequest->contract->changeStatus(Contract::STATUS_CANCELED_ERROR_PAYMENT);
			}
			else
				return response("Not a relevant payment notification.", 200);
		}
		else
			return response("Payment result was already notified and applied.", 200);


		if(config("app.debug")) {
			\Log::info("MercadoPago IPN payment (PaymentRequest ".$paymentRequest->id.") marked as ".$payment->status);
		}

		return response("Payment updated successfully.", 200);
	}



	public function error($msg = "", $code = 400)
	{
		\Log::warning("MercadoPago IPN error: " . $msg.PHP_EOL."Request data: ".implode(' / ', Request::all()));
		return response($msg, $code);
	}

}
