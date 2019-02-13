<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use anlutro\LaravelSettings\SettingStore;


class SettingsController extends AdminBaseController
{
    

	public function __construct()
	{
		parent::__construct();
		$this->middleware("admin_only");
	}

    /**
     * Muestra formulario de menu de opciones configurables
     * @return [type] [description]
     */
	public function show()
	{
		return view("back.settings")->with([
			"usd_to_eur" => setting()->get('usd_to_eur_rate'),
			"profit_margin" => setting()->get('profit_margin')
		]);
	}


	/**
	 * Actualiza opciones
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function update(Request $request)
	{
		
		$request->validate([
			"usd_to_eur_rate" => "required|numeric",
			"profit_margin" => "required|numeric"
		]);

		setting()->set("usd_to_eur_rate", $request->usd_to_eur_rate);
		setting()->set("profit_margin", $request->profit_margin);
		setting()->save();
		
		return redirect("settings");
	}

}
