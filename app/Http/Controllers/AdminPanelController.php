<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Quotation;
use \App\Contract;


class AdminPanelController extends Controller
{


	public function home()
	{
		return view("back.home");
	}



	public function quotationList()
	{

		$quotations = Quotation::with(["country_from", "contract"])->orderBy("created_at", "desc")->get();

		return view("back.quotations")->with("quotations", $quotations);
	}



	public function quotationDetails($id)
	{
		$quotation = Quotation::with("products", "country_from", "contract")->find($id);
		return view("back.quotation")->with(["quotation" => $quotation]);
	}



	public function contractList()
	{
		$contracts = Contract::with([
			"status", 
			"product",
			"quotation.country_from",
			"active_payment_request"
		])->orderBy("created_at", "desc")->get();
		
		return view("back.contracts")->with("contracts", $contracts);
	}



	public function contractDetails($id)
	{
		$contract = Contract::with([
			"status_history.status", 
			"product",
			"quotation.country_from",
			"active_payment_request"
		])->find($id);
		
		return view("back.contract")->with("contract", $contract);

	}



	public function settings()
	{
		return view("back.settings");
	}


}
