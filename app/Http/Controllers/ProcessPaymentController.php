<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Contract;

use \App\PaymentRequest;
use \App\MercadoPagoRequest;
use \App\PaypalRequest;

use App\Library\MercadoPago\MP;
use App\Library\PayPal\Paypal;



class ProcessPaymentController extends Controller
{
    
	/**
	 * Setear lenguaje de App (si se pasó)
	 */
	public function __construct()
	{
		if(request()->has("lang") && in_array(request("lang"), config("app.langs"))) {
			\App::setLocale(request("lang"));
		}
	}


	/**
	 * Procesa pago de mercadopago luego de realizar el mismo y ser redirigido
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function processMercadoPagoPayment(Request $request)
	{

		MP::APIAuth();

		if($request->has(["collection_id", "collection_status", "preference_id"])) // sólo se usa collection_id para comprobar el pago
		{

			// si presiona "volver al sitio del vendedor" sin que la solicitud sea rechazada.
			if($request->collection_id == "null" && $request->collection_status == "null")
			{
				$mpRequest = MercadoPagoRequest::findByPreferenceId($request->preference_id);
				if($mpRequest == null)
					return "Error.";
				return redirect(uri_localed("{contract}/".$mpRequest->parentRequest->contract->number));
			}


			$payment = \MercadoPago\Payment::find_by_id($request->collection_id);
			if($payment->id == null)
				return "error";

			$merchantOrder = \MercadoPago\MerchantOrder::find_by_id($payment->order->id);
			if($merchantOrder->id == null)
				return "error";

			$mpRequest = MercadoPagoRequest::findByPreferenceId($merchantOrder->preference_id);
			if($mpRequest == null)
				return "error";

			$paymentRequest = $mpRequest->parentRequest;


			if($paymentRequest->status == PaymentRequest::STATUS_UNPAID || $paymentRequest->status == PaymentRequest::STATUS_PROCESSING)
			{
				
				if($request->collection_status == "approved" && $payment->status == "approved") // pagó
				{	
					$mpRequest->markAsPaidOut(
						$merchantOrder->id, 
						$payment->id, 
						$payment->payment_method_id,
						date("Y-m-d H:i:s", strtotime($payment->date_approved)),
						$payment->fee_details[0]->amount 
					);

					$paymentRequest->contract->changeStatus(Contract::STATUS_PROCESSING); // ya se pagó, ahora se marca como "procesando" la contratacion

					$mail = new \App\Mail\ContractPaidAdminNotif($paymentRequest->contract, $paymentRequest);
					\Mail::to("agusfn20@gmail.com")->send($mail);
				}
				else if($request->collection_status == "in_process" && $payment->status == "in_process")
				{
					$mpRequest->markAsProcessing($request->collection_id);
				}
				else if(/*$request->collection_status == "rejected" &&*/ $request->has("ft") && $request->ft == $mpRequest->failure_url_token)
				{
					$paymentRequest->markAsFailed();
					$paymentRequest->contract->changeStatus(Contract::STATUS_CANCELED_ERROR_PAYMENT);
				}

			}

			return redirect(uri_localed("{contract}/".$paymentRequest->contract->number));

		}
		else 
			return redirect("");

	}



	/**
	 * Procesa pago de paypal luego de realizar el mismo y ser redirigido.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function processPayPalPayment(Request $request)
	{

		if($request->has(["paymentId", "PayerID", "token"]))
		{

			$ppRequest = PaypalRequest::where([
				["pp_payment_id", $request->paymentId],
				["pp_payment_token", $request->token]
			])->first();

			if($ppRequest == null)
				return "Payment not found.";

			$paymentRequest = $ppRequest->parentRequest;

			
			if($paymentRequest->status == PaymentRequest::STATUS_UNPAID)
			{

				$paypal = new Paypal();
				$payment = $paypal->executePayment($request->paymentId, $request->PayerID);
				
				if($payment != false)
				{
					if($payment->state == "approved")
					{
						
						$pay_time = $payment->transactions[0]->related_resources[0]->sale->create_time;

						$ppRequest->markAsPaidOut(
							$request->PayerID,
							$payment->transactions[0]->related_resources[0]->sale->id,
							date("Y-m-d H:i:s", strtotime($pay_time)),
							$payment->transactions[0]->related_resources[0]->sale->transaction_fee->value
						);

						$paymentRequest->contract->changeStatus(Contract::STATUS_PROCESSING);

						$mail = new \App\Mail\ContractPaidAdminNotif($paymentRequest->contract, $paymentRequest);
						\Mail::to("agusfn20@gmail.com")->send($mail);
					}
					else
					{
						$paymentRequest->markAsFailed();
						$paymentRequest->contract->changeStatus(Contract::STATUS_CANCELED_ERROR_PAYMENT);
					}
				}
				else
					return "There was a problem excecuting the payment. Please try reloading the page or contact support.";

			}
			

			return redirect(uri_localed("{contract}/".$paymentRequest->contract->number));
			

		}
		else if($request->has("token")) // si se presiona "volver atras", o se vuelve al link de pago ya habiendo pagado
		{
			$ppRequest = PaypalRequest::findByPPToken($request->token);
			if($ppRequest)
				return redirect(uri_localed("{contract}/".$ppRequest->parentRequest->contract->number));
			else
				return "Error.";
			
		}
		else
			return redirect("");



	}


}
