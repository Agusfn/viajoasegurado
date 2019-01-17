<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\Contract;

class ContractController extends AdminBaseController
{
	
	/**
	 * Lista contrataciones
	 * @return [type] [description]
	 */
	public function list()
	{
		$contracts = Contract::with([
			"status", 
			"product",
			"quotation.country_from",
			"active_payment_request"
		])->orderBy("created_at", "desc")->paginate(20);
		
		return view("back.contracts")->with("contracts", $contracts);
	}


	/**
	 * Muestra detalles de contratacion
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function details($id)
	{
		$contract = Contract::with([
			"status_history.status", 
			"product",
			"quotation.country_from",
			"active_payment_request"
		])->find($id);
		
		return view("back.contract")->with("contract", $contract);

	}

	/**
	 * Actualiza la nota de una contratacion
	 * @param  Request $request [description]
	 * @param  [type]  $id      [description]
	 * @return [type]           [description]
	 */
	public function updateNote(Request $request, $id)
	{

		$contract = Contract::find($id);
		if(!$contract || !$request->has("notes"))
			return "Error";

		$contract->notes = $request->notes;
		$contract->save();

		return redirect("contracts/".$contract->id);
	}


	/**
	 * Cambia el estado de una contratación a completada y notifica al cliente por email de envio de voucher
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function markVoucherSent($id)
	{
		$contract = Contract::with(["quotation"])->find($id);
		if(!$contract)
			return "Error";

		$contract->changeStatus(Contract::STATUS_COMPLETED);

		$mail = new \App\Mail\ContractCompleted($contract);
		\Mail::to($contract->contact_email)->locale($contract->quotation->lang)->send($mail);

		return redirect("contracts/".$contract->id);
	}


	// Las opciones de cancelación las vamos a dejar en stand-by para hacerlas post-lanzamiento.
	// Mientras la unica opcion de cancelación va a ser por expiración de tiempo de forma automática.
	
	/*public function cancel($id)
	{
		$contract = Contract::find($id);

		if(!$contract)
			return "Error";

		if($contract->current_status_id == Contract::STATUS_PAYMENT_PENDING) 
		{



		}


	}*/


}
