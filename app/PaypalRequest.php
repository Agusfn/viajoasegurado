<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\PaymentRequest;
use \App\Library\PayPal\Paypal;


class PaypalRequest extends Model
{
   
	const METHOD_CODE_NAME = "paypal";


	protected $guarded = [];


	/**
	 * Genera una solicitud de PayPal por medio de la API SDK y una instancia de PaypalRequest y PaymentRequest "padre" asociada.
	 * @param  int $contract_id   id de contratación
	 * @param  string $item_title    nombre del producto
	 * @param  int $item_quantity cantidad de unidades
	 * @param  float $unit_price    precio por unidad
	 * @return PaypalRequest|false                Instancia de PaypalRequest con clase "padre" PaymentRequest asociado con toda la información de la solicitud.
	 */
	public static function create($contract_id, $contract_number, $item_title, $item_quantity, $unit_price)
	{

		$ppRequest = new self();

		$ppRequest->fill([
			"item_title" => $item_title,
			"item_quantity" => $item_quantity,
			"item_unit_price" => $unit_price
		]);

		$ppRequest->save();


		$paypal = new Paypal();
		$payment = $paypal->createPayment($ppRequest, $contract_number);

		if($payment == false)
		{
			$ppRequest->delete();
			return false;
		}

		$paymentRequest = PaymentRequest::create([
			"contract_id" => $contract_id,
			"payment_method_codename" => self::METHOD_CODE_NAME,
			"method_request_id" => $ppRequest->id,
			"status" => PaymentRequest::STATUS_UNPAID,
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


	/**
	 * Buscar PaypalRequest por medio del token (dato interno de PayPal) de la solicitud de pago de paypal
	 * @param string $token 	token de pago
	 * @return PaypalRequest|null
	 */
	public static function findByPPToken($token)
	{
		return self::where("pp_payment_token", $token)->first();
	}



	public function parentRequest()
	{
		return $this->belongsTo("App\PaymentRequest", "payment_request_id");
	}


	/**
	 * Marcar PaymentRequest "padre" como aprobado, y agrega datos del pago a esta PaypalRequest
	 * @param  string $payerId         dato interno del pago de paypal
	 * @param  string $transactionId   dato interno del pago de paypal
	 * @param  string $date_paid       fecha pago Y-m-d H:i:s
	 * @param  float $transaction_fee 	comision servicio pagos
	 * @return null
	 */
	public function markAsPaidOut($payerId, $transactionId, $date_paid, $transaction_fee)
	{
		
		$this->pp_payer_id = $payerId;
		$this->pp_transaction_id = $transactionId;
		$this->save();

		$this->parentRequest->markAsPaidOut($date_paid, $transaction_fee);
	}

}
