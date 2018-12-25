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
			"item_unit_price" => $unit_price
		]);

		$ppRequest->save();


		$paypal = new Paypal();
		$payment = $paypal->createPayment($ppRequest);

		if($payment == false)
		{
			$ppRequest->delete();
			return false;
		}

		$paymentRequest = PaymentRequest::create([
			"contract_id" => $contract_id,
			"payment_method_codename" => self::METHOD_CODE_NAME,
			"method_request_id" => $ppRequest->id,
			"status" => PaymentRequest::STATUS_PENDING,
			"payment_url" => $payment->getApprovalLink(),
			"total_ammount" => round($item_quantity * $unit_price, 2),
			"currency_code" => "USD"
		]);


		$ppRequest->fill([
			"payment_request_id" => $paymentRequest->id,
			"approval_url" => $payment->getApprovalLink(),
			"pp_payment_id" => $payment->id,
			"pp_payment_token" => $payment->getToken()
		]);
		$ppRequest->save();


		return $ppRequest;
	}



	public function parentRequest()
	{
		return $this->belongsTo("App\PaymentRequest", "payment_request_id");
	}



	public function markAsPaidOut($payerId, $transactionId, $date_paid, $transaction_fee)
	{
		
		$this->pp_payer_id = $payerId;
		$this->pp_transaction_id = $transactionId;
		$this->save();

		$payRequest = $this->parentRequest->markAsPaidOut($date_paid, $transaction_fee);
	}

}
