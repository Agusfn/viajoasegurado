<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\Quotation;

class QuotationController extends AdminBaseController
{


	/**
	 * Muestra listado de cotizaciones
	 * @return [type] [description]
	 */
	public function list()
	{
		$quotations = Quotation::with([
			"country_from", 
			"contract"
		])->orderBy("created_at", "desc")->paginate(20);

		return view("back.quotations")->with("quotations", $quotations);
	}


	/**
	 * Muestra detalles de cotizacion
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function details($id)
	{
		$quotation = Quotation::with("products", "country_from", "contract")->find($id);
		return view("back.quotation")->with(["quotation" => $quotation]);
	}


}
