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
    

	// marca pago como acreditado o cancelado.
	
	public function processMercadoPagoPayment(Request $request)
	{

		MP::APIAuth();

		if($request->has(["collection_id", "collection_status", "preference_id"])) // sólo se usa collection_id para comprobar el pago
		{

			// si presiona "volver al sitio del vendedor" sin que la solicitud sea rechazada.
			if($request->collection_id == "null" && $request->collection_status == "null")
			{
				// buscar contratacion por preference id y redirigir a pag contratacion
				return "pago no realizado (ni cancelado)";
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


			if($paymentRequest->status == PaymentRequest::STATUS_PENDING)
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

					$paymentRequest->contract->changeStatus(Contract::STATUS_PAID);

					return redirect(uri_localed("{contract}/".$paymentRequest->contract->number));
				}
				else if(/*$request->collection_status == "rejected" &&*/ $request->has("ft") && $request->ft == $mpRequest->failure_url_token)
				{
					$paymentRequest->markAsCanceled();
					return redirect(uri_localed("{contract}/".$paymentRequest->contract->number));
				}

			}

			return redirect(uri_localed("{contract}/".$paymentRequest->contract->number));


		}
		else 
			return "error";

	}




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

			
			if($paymentRequest->status == PaymentRequest::STATUS_PENDING)
			{

				$paypal = new Paypal();

				if(!$payment = $paypal->executePayment($request->paymentId, $request->PayerID))
					return "Error executing payment"; // ver si esto se genera por un error de conexion/del sistema o simplemente por algun problema con el pago

				
				if($payment->state == "approved")
				{
					
					$pay_time = $payment->transactions[0]->related_resources[0]->sale->create_time;

					$ppRequest->markAsPaidOut(
						$request->PayerID,
						$payment->transactions[0]->related_resources[0]->sale->id,
						date("Y-m-d H:i:s", strtotime($pay_time)),
						$payment->transactions[0]->related_resources[0]->sale->transaction_fee->value
					);

					$paymentRequest->contract->changeStatus(Contract::STATUS_PAID);


					return redirect(uri_localed("{contract}/".$paymentRequest->contract->number));

				}
				else
					return "Payment failed."; // la solicitud de pago no sirve mas? O sigue sirviendo?

			}
			else
				return redirect(uri_localed("{contract}/".$paymentRequest->contract->number));
			

		}
		else if($request->has("token")) // el pago no se concretó
		{
			return "[ir a pagina de la contratacion a partir del token]";
		}
		else
			return "No se proporcionaron los params.";



	}


}
