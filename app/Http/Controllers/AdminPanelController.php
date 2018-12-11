<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Quotation;


class AdminPanelController extends Controller
{


	public function home()
	{
		return view("back.home2");
	}




	public function quotationList()
	{

		$quotations = Quotation::all();

		return view("back.quotations2")->with("quotations", $quotations);
	}


	public function quotationDetails($id)
	{
		$quotation = Quotation::find($id);

		if($quotation != null)
		{
			$quotationProducts = $quotation->products()->get();
			return view("back.quotation2")->with(["quotation" => $quotation, "quotationProducts" => $quotationProducts]);
		}
		else
			return view("back.quotation2")->with("quotation", $quotation);

		

	}



	public function contractList()
	{
		return view("back.contracts");
	}



	public function settings()
	{
		return view("back.settings");
	}


}
