<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\QuotationProduct;
use \App\PaymentRequest;
use \App\ContractStatusHistory;


class Contract extends Model
{
    
	const STATUS_PAYMENT_PENDING = 1; // pago pendiente (se puede cancelar con cualquiera de los 3 estados)
	const STATUS_PROCESSING = 2; // Pagada exitosamente, esperando envio de poliza. (Sólo se puede cancelar con STATUS_CANCELED_OTHER y con reembolso)
	const STATUS_COMPLETED = 3; // Voucher enviado. No se puede volver atrás de este paso.
	const STATUS_CANCELED_UNPAID = 4; // cancelado porque no se pagó
	const STATUS_CANCELED_ERROR_PAYMENT = 5; // cancelado por error en pago
	const STATUS_CANCELED_OTHER = 7; // cancelado por otro motivo (puede tener reembolso)




	protected $guarded = [];



	/**
	 * Buscar contratación por contract_number
	 * @param  int $number contract_number
	 * @return Contract
	 */
	public static function findByNumber($number)
	{
		return self::where("number", $number)->first();
	}


	/**
	 * Genera un numero random único de 15 digitos para identificar a la contratación.
	 * @return int
	 */
	public static function randomNumber()
	{
		
		$digits = "";
		for ($i = 0; $i < 9; $i++) {
			$digits .= rand(0, 9);
		}

		if(self::where("number", $digits)->count() == 0)
			return $digits;
		else
			return self::randomNumber();
	}



	/**
	 * Cancela las contrataciones en estado STATUS_PAYMENT_PENDING (y cuyos pagos no se hayan realizado) que se hayan creado hace 3 horas o más.
	 * @return null
	 */
	public static function cancelUnpaidContracts()
	{
		$contracts = Contract::where([
			["current_status_id", self::STATUS_PAYMENT_PENDING],
			["created_at", "<", date("Y-m-d H:i:s", strtotime("-3 hour"))]
		])->get();

		foreach($contracts as $contract) 
		{
			if($contract->active_payment_request != null && $contract->active_payment_request->status == PaymentRequest::STATUS_UNPAID)
			{
				$contract->active_payment_request->changeStatus(PaymentRequest::STATUS_EXPIRED);
				$contract->changeStatus(self::STATUS_CANCELED_UNPAID);
			}
		}

	}



	/**
	 * Cambiar estado de la contratación y registra el cambio de estado en el historial.
	 * @param  int $status_id 	número de estado
	 * @return null
	 */
	public function changeStatus($status_id)
	{
		$this->current_status_id = $status_id;
		$this->save();


		ContractStatusHistory::create([
			"contract_id" => $this->id,
			"status_id" => $status_id
		]);

	}


	/**
	 * Obtiene array con n elementos, donde cada elemento es un array con datos de un pasajero. n es la cantidad de pasajeros [1,5]
	 * @return array
	 */
	public function getPassengerDetails()
	{

		$csvs = [];
		$csvs[] = $this->beneficiary_1;
		$csvs[] = $this->beneficiary_2;
		$csvs[] = $this->beneficiary_3;
		$csvs[] = $this->beneficiary_4;
		$csvs[] = $this->beneficiary_5;

		$passengers = [];

		foreach($csvs as $csv)
		{
			$passg_details = explode(",", $csv);
			if(sizeof($passg_details) == 4)
			{

				$birthdate = new \DateTime($passg_details[3]);
				$today     = new \DateTime();
				$interval  = $today->diff($birthdate);
				$age = $interval->format('%y');

				$passengers[] = array(
					"name" => $passg_details[0],
					"surname" => $passg_details[1],
					"identification" => $passg_details[2],
					"date_birth" => $passg_details[3],
					"age" => $age
				);
			}
		}

		return $passengers;

	}




	public function active_payment_request()
	{
		return $this->belongsTo("App\PaymentRequest", "active_payment_req_id")->with("payment_method");
	}


	public function quotation()
	{
		return $this->belongsTo("App\Quotation");
	}



	public function product()
	{
		return $this->belongsTo("App\QuotationProduct", "quotation_product_id");
	}

	public function status()
	{
		return $this->belongsTo("\App\ContractStatus", "current_status_id");
	}


	public function status_history()
	{
		return $this->hasMany("App\ContractStatusHistory");
	}


	/**
	 * Obtiene colección de solicitudes de pago asociadas a esta contratación. De más vieja a más nueva (siendo la última la activa)
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function payment_requests()
	{
		return PaymentRequest::where("contract_id", $this->id)->orderBy("created_at", "asc")->get();
	}


}
