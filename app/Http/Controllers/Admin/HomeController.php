<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class HomeController extends AdminBaseController
{
 
 	/**
 	 * Redirige a cotizaciones
 	 * @return [type] [description]
 	 */
	public function index()
	{
		return redirect("quotations");
		//return view("back.home");
	}


}
