<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\MercadoPagoRequest;
use \App\PaypalRequest;

class PaymentRequest extends Model
{
    
	protected $guarded = [];

	const STATUS_UNPAID = "unpaid";	// no se hizo el pago ni el intento del mismo
	const STATUS_PROCESSING = "processing"; // el procesador de pago lo está procesando (por lo gral no se usa)
	const STATUS_APPROVED = "approved";
	const STATUS_FAILED = "failed"; // Falló y ya no sirve más.
	const STATUS_REFUNDED = "refunded";



	/**
	 * Obtiene la solicitud de pago específica asociada a esta instancia de solicitud de pago.
	 * @return mixed 	Instancia de solicitud de pago.
	 */
	public function provider_request()
	{

		if($this->payment_method_codename == MercadoPagoRequest::METHOD_CODE_NAME)
			return MercadoPagoRequest::find($this->method_request_id);

		else if($this->payment_method_codename == PaypalRequest::METHOD_CODE_NAME)
			return PaypalRequest::find($this->method_request_id);

	}


	public function markAsPaidOut($date_paid, $transaction_fee)
	{
		
		$this->status = self::STATUS_APPROVED;
		$this->date_paid = $date_paid;
		$this->transaction_fee = $transaction_fee;
		$this->net_ammount = $this->total_ammount - $transaction_fee;

		$this->save();

		// Cambiar estado de la contratacion asociada
		// Mandar mail?

	}


	public function markAsFailed()
	{
		$this->status = self::STATUS_FAILED;
		$this->save();
	}





	public function contract()
	{
		return $this->belongsTo('\App\Contract');
	}


	public function payment_method()
	{
		return $this->belongsTo("App\PaymentMethod", "payment_method_codename", "code_name");
	}



}
