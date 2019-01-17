<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract;

class AdminBaseController extends Controller
{
    

	/**
	 * Arma lista de notificaciones para mostrar en todo el panel admin para usuarios logueados.
	 */
	public function __construct()
	{

		$notifications = [];

		$pending_contracts_count = Contract::where("current_status_id", Contract::STATUS_PROCESSING)->count();

		if($pending_contracts_count > 0)
		{
			$notifications[] = array(
				"url" => url("contracts"), 
				"message" => "Hay ".$pending_contracts_count." contrataciones para enviar voucher."
			);
		}

		\View::share('notifications', $notifications);
	}


}
