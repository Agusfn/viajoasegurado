<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\PaymentRequest;
use \App\Library\PayPal\Paypal;


class PaypalRequest extends Model
{
   
	const METHOD_CODE_NAME = "paypal";


	protected $guarded = [];


	public static function create($contract_id, $item_title, $item_quantity, $unit_price)
	{

		$ppRequest = new self();

		$ppRequest->fill([
			"item_title" => $item_title,
			"item_quantity" => $item_quantity,
			"item_unit_price" => $unit_price,
			"approval_url" => ""
		]);

		$ppRequest->save();


		$paypal = new Paypal();
		$payment = $paypal->createPayment($ppRequest);

		if($payment == false)
		{
			$ppRequest->delete();
			return false;
		}

		$ppRequest->approval_url = $payment->getApprovalLink();
		$ppRequest->save();


		$paymentRequest = PaymentRequest::create([
			"contract_id" => $contract_id,
			"status" => PaymentRequest::STATUS_PENDING,
			"payment_method" => self::METHOD_CODE_NAME,
			"method_request_id" => $ppRequest->id
		]);


		return $ppRequest;
	}



	/**
	 * Devuelve instancia del objeto "padre" PaymentRequest
	 * @return mixed
	 */
	public function parentRequest()
	{
		return PaymentRequest::where([["payment_method", self::METHOD_CODE_NAME], ["method_request_id", $this->id]])->first();
	}

}
