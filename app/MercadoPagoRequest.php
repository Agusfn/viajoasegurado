<?php

namespace App;

use \App\PaymentRequest;

use Illuminate\Database\Eloquent\Model;
use \App\Library\MercadoPago\MP;

class MercadoPagoRequest extends Model
{
    
    const METHOD_CODE_NAME = "mercadopago-ar";



	protected $guarded = [];


	/**
	 * Crea un PaymentRequest, un MercadoPagoRequest asociado, y genera la solicitud de pago en ARS.
	 * @param int 		$contract_id 	id de la contratacion asociada.
	 * @param array		$attributes		atributos del modelo
	 * @return mixed 	MercadoPagoRequest o FALSE
	 */
	
	public static function create($contract_id, $contract_number, $item_id, $item_title, $item_quantity, $unit_price, $payer_email, $payer_name, $payer_surname)
	{

		$mpRequest = new self();

		$mpRequest->fill([
			"item_id" => $item_id,
			"item_title" => $item_title,
			"item_quantity" => $item_quantity,
			"item_currency_code" => "ARS",
			"item_unit_price" => $unit_price,
			"payer_email" => $payer_email,
			"payer_name" => $payer_name,
			"payer_surname" => $payer_surname,
			"failure_url_token" => str_random(10),
			"expiration_date" => date("Y-m-d\TH:i:s.000O", strtotime("+3 hour"))
		]);
		$mpRequest->save();

		$preference = MP::createPreference($mpRequest, $contract_number);


		if($preference == false)
		{
			$mpRequest->delete();
			return false;
		}


		$paymentRequest = PaymentRequest::create([
			"contract_id" => $contract_id,
			"payment_method_codename" => self::METHOD_CODE_NAME,
			"method_request_id" => $mpRequest->id,
			"status" => PaymentRequest::STATUS_UNPAID,
			"payment_url" => $preference->init_point,
			"total_ammount" => round($item_quantity * $unit_price, 2),
			"currency_code" => "ARS"
		]);

		$mpRequest->fill([
			"payment_request_id" => $paymentRequest->id,
			"preference_id" => $preference->id,
			"preference_url" => $preference->init_point,
			"preference_sandbox_url" => $preference->sandbox_init_point
		]);
		$mpRequest->save();


		return $mpRequest;
	}


	/**
	 * Buscar por preference id
	 * @param  string $preference_id
	 * @return MercadoPagoRequest|null
	 */
	public static function findByPreferenceId($preference_id)
	{
		return self::where("preference_id", $preference_id)->first();
	}



	/**
	 * Marca la PaymentRequest padre como pago aprobado. Además le carga datos del pago al MercadoPagoRequest
	 * @param  int $merchant_order_id	 id interno mercadopago
	 * @param  int $collection_id    id interno mercadopago
	 * @param  string $collection_method  	medio de pago 
	 * @param  string $date_paid         fecha pago Y-m-d H:i:s
	 * @param  float $transaction_fee   comision del procesador de pagos
	 * @return null
	 */
	public function markAsPaidOut($merchant_order_id, $collection_id, $collection_method, $date_paid, $transaction_fee)
	{
		
		$this->merchant_order_id = $merchant_order_id;
		$this->collection_id = $collection_id;
		$this->collection_method = $collection_method;
		$this->save();

		$this->parentRequest->markAsPaidOut($date_paid, $transaction_fee);
	}


	/**
	 * Marca el PaymentRequest como procesando pago. Agrega info al MercadopagoRequest del id de pago de MP.
	 * @param  int $collection_id    id interno mp
	 * @return null
	 */
	public function markAsProcessing($collection_id) 
	{
		$this->collection_id = $collection_id;
		$this->save();

		$this->parentRequest->status = PaymentRequest::STATUS_PROCESSING;
		$this->parentRequest->save();
	}




	public function parentRequest()
	{
		return $this->belongsTo("App\PaymentRequest", "payment_request_id");
	}


}
