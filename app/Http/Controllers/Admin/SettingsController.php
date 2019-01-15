<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use anlutro\LaravelSettings\SettingStore;


class SettingsController extends AdminBaseController
{
    
	public function show()
	{
		return view("back.settings")->with([
			"usd_to_eur" => setting()->get('usd_to_eur_rate'),
			"profit_margin" => setting()->get('profit_margin')
		]);
	}


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
