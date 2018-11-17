<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Quotation;


class AdminPanelController extends Controller
{
    

	public function showQuotations()
	{

		$quotations = Quotation::all();

		return view("admin.quotations")->with("quotations", $quotations);
	}


	public function quotationDetails($id)
	{
		$quotation = Quotation::find($id);

		if($quotation != null)
		{
			$quotationProducts = $quotation->products()->get();
			return view("admin.quotation")->with(["quotation" => $quotation, "quotationProducts" => $quotationProducts]);
		}
		else
			return view("admin.quotation")->with("quotation", $quotation);

		

	}

}
