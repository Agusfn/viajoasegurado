<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Library\AseguratuViaje\ATVApi;

class QuotationProduct extends Model
{
    

	protected $guarded = [];


	/**
	 * Propiedades ocultas al enviar Json
	 * @var array
	 */
	protected $hidden = [
		"id", 
		"created_at", 
		"updated_at", 
		"quotation_id", 
		"provider_atv_id", 
		"coverage_details_json", 
		"cost", 
		"gross_cost", 
		"cost_currency_code"
	];



	/**
	 * Obtiene montos de coberturas via API de ATV y los guarda en un campo de la DB como JSON (procesado)
	 * 
	 * @return boolean	success
	 */
	public function fetchAndSaveCoverageDetails($locale)
	{
		
		$coverages = ATVApi::getProductCoverage($locale, $this->product_atv_id);

		if($coverages === false)
			return false;


		$new_coverages = []; // array de arrays con nombre y monto de cobertura.

		foreach($coverages["beneficios"] as $coverage)
		{
			array_push($new_coverages, array(
				"description" => $coverage["Descripcion"],
				"ammount" => $coverage["Coberturas"][0]["Valor"]
			));
		}

		$this->coverage_details_json = json_encode($new_coverages);
		$this->save();

		return true;
	}



}
