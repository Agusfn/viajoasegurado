<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \App\ContractStatusHistory;


class Contract extends Model
{
    
	const STATUS_PAYMENT_PENDING = "payment_pending";
	const STATUS_PAID = "paid";
	const STATUS_COMPLETED = "completed";
	const STATUS_CANCELED_UNPAID = "canceled_unpaid";
	const STATUS_CANCELED_REQUESTED = "canceled_requested";




	protected $guarded = [];



	/**
	 * Genera un numero random único de 6 digitos para identificar a la contratación.
	 * @return int
	 */
	public static function randomNumber()
	{
		
		$number = rand(100000,999999);
		
		if(self::where("number", $number)->count() == 0)
			return $number;
		else
			return self::randomNumber();

	}



	public function changeStatus($status_code)
	{
		$this->status_code = $status_code;
		$this->save();


		ContractStatusHistory::create([
			"contract_id" => $this->id,
			"status_code" => $status_code
		]);

	}

}
