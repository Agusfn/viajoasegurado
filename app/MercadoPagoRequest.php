<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Library\MercadoPago\MP;

class MercadoPagoRequest extends Model
{
    
    const METHOD_CODE_NAME = "mercadopago-ar";



	protected $guarded = [];


	/**
	 * Crea un PaymentRequest, un MercadoPagoRequest asociado, y genera la solicitud de pago.
	 * @param int 		$contract_id 	id de la contratacion asociada.
	 * @param array		$attributes		atributos del modelo
	 * @return mixed 	MercadoPagoRequest o FALSE
	 */
	
	public static function create($contract_id, $item_id, $item_title, $item_quantity, $unit_price, $payer_email, $payer_name, $payer_surname)
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
			"expiration_date" => date("Y-m-d\TH:i:s.000O", strtotime("+30 minute"))
		]);
		$mpRequest->save();

		$preference = MP::createPreference($mpRequest);


		if($preference == false)
		{
			$mpRequest->delete();
			return false;
		}

		$mpRequest->fill([
			"preference_id" => $preference->id,
			"preference_url" => $preference->init_point,
			"preference_sandbox_url" => $preference->sandbox_init_point
		]);
		$mpRequest->save();


		$paymentRequest = PaymentRequest::create([
			"contract_id" => $contract_id,
			"status" => PaymentRequest::STATUS_PENDING,
			"payment_method" => self::METHOD_CODE_NAME,
			"method_request_id" => $mpRequest->id
		]);



		return $mpRequest;
	}



	public static function findByPreferenceId($preference_id)
	{
		return self::where("preference_id", $preference_id)->first();
	}




	public function markAsPaidOut($merchant_order_id, $collection_id, $collection_method, $date_paid)
	{
		
		$this->merchant_order_id = $merchant_order_id;
		$this->collection_id = $collection_id;
		$this->collection_method = $collection_method;
		$this->save();

		$payRequest = $this->parentRequest();
		$payRequest->markAsPaidOut($date_paid);
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
