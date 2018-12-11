<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\MercadoPagoRequest;
use \App\PaypalRequest;

class PaymentRequest extends Model
{
    
	protected $guarded = [];

	
	const STATUS_PENDING = "pending";
	const STATUS_APPROVED = "approved";
	const STATUS_CANCELED = "canceled";
	const STATUS_REFUNDED = "refunded";



	/**
	 * Obtiene la solicitud de pago específica asociada a esta instancia de solicitud de pago.
	 * @return mixed 	Instancia de solicitud de pago.
	 */
	public function provider_request()
	{

		if($this->payment_method == MercadoPagoRequest::METHOD_CODE_NAME)
			return MercadoPagoRequest::find($this->method_request_id);

		else if($this->payment_method == PaypalRequest::METHOD_CODE_NAME)
			return PaypalRequest::find($this->method_request_id);

	}


	public function markAsPaidOut($date_paid)
	{
		

		$this->status = self::STATUS_APPROVED;
		$this->date_paid = $date_paid;
		$this->save();


		// Cambiar estado de la contratacion asociada
		// Mandar mail?

	}


	public function markAsCanceled()
	{
		$this->status = self::STATUS_CANCELED;
		$this->save();
	}

	/*public function contract()
	{
		return $this->hasOne('App\Contract');
	}*/




}
