<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\PaymentRequest;
use \App\MercadoPagoRequest;

use App\Library\MercadoPago\MP;


class ProcessContractPaymentController extends Controller
{
    

	// marca pago como acreditado o cancelado.
	
	public function processMercadoPagoPayment(Request $request)
	{

		MP::APIAuth();

		if($request->has(["collection_id", "collection_status", "preference_id"]))
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

			$paymentRequest = $mpRequest->parentRequest();


			if($paymentRequest->status == PaymentRequest::STATUS_PENDING)
			{
				
				if($request->collection_status == "approved" && $payment->status == "approved") // pagó
				{
					$mpRequest->markAsPaidOut(
						$merchantOrder->id, 
						$payment->id, 
						$payment->payment_method_id,
						date("Y-m-d H:i:s", strtotime($payment->date_approved))
					);
					echo "marcado como pagado";
				}
				else if(/*$request->collection_status == "rejected" &&*/ $request->has("ft") && $request->ft == $mpRequest->failure_url_token)
				{
					$paymentRequest->markAsCanceled();
					echo "marcado como pago cancelado";
				}

			}

			return "[redirigir a página de contratación]";
			// redirigir a "/contratar/Contract.number"


		}
		else 
			return "error 1";

	}


}
