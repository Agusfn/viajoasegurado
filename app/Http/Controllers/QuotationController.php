<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateQuotation;
use App\Quotation;

use \App\Library\AseguratuViaje\ATV;
use \App\Library\AseguratuViaje\ATVAPi;


class QuotationController extends Controller
{
    


    /**
     * Crea una nueva cotización (sin cotizar aun) enviando desde el formulario cotizador.
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function createQuotation(CreateQuotation $req)
	{
		
		$req->validated();


		if($req->has("travel_pregnant"))
		{
			$ages = $req->pregnant_age;
			$gest_weeks = $req->gestation_weeks;
		} 
		else
		{
			for($i=1; $i<=$req->passenger_ammount; $i++) {
				if(!$req->filled("age".$i))
					return redirect('')->withErrors("Insert all ".$req->passenger_ammount." ages.");
			}
			$ages = Quotation::agesToCsv($req->passenger_ammount, $req->age1, $req->age2, $req->age3, $req->age4, $req->age5);
			$gest_weeks = 0;
		}

		

		$quotation = new Quotation();

		$quotation->fill([
			"expiration_date" => date("Y-m-d H:i:s", strtotime("+3 hour")),
			"customer_email" => $req->email,
			"origin_country_code" => $req->country_code_from,
			"destination_region_code" => $req->region_code_to,
			"trip_type_code" => 1, // configurar bien esto
			"date_from" => \DateTime::createFromFormat('d/m/Y', $req->date_start)->format("Y-m-d"),
			"date_to" => \DateTime::createFromFormat('d/m/Y', $req->date_end)->format("Y-m-d"),
			"passenger_ammount" => $req->passenger_ammount,
			"passenger_ages" => $ages,
			"gestation_weeks" => $gest_weeks,
			"url_code" => Quotation::generateUrlCode(),
			"lang" => \App::getLocale(),
			"customer_ip" => request()->ip(),
			"atv_token" => "",
			"quoted" => false,
			"contract_id" => null
		]);

		$quotation->save();

		return redirect(uri_localed("{quote}")."/".$quotation->url_code);
	}


	/**
	 * Dirige la página donde se muestran las cotizaciones
	 * @param  [type] $url_id [description]
	 * @return [type]         [description]
	 */
	public function displayQuotation(Request $request)
	{
		$parameters = [
			"countries_from" => ATV::getCountriesFrom(), 
            "regions_to" => ATV::getRegionsTo(),
            "quotationFound" => false
		];

		if($request->url_code != null && $quotation = Quotation::findByUrlCode($request->url_code))
		{

			$parameters["quotationFound"] = true;
			$parameters["url_code"] = $request->url_code;

			if($quotation->expired() || $quotation->contract_id != null) // si expiró o ya se generó una contratación
				$parameters["quotationExpired"] = true;
			else {
				$parameters["trip_to"] = ATV::getRegionName($quotation->destination_region_code);
				$parameters["quotationExpired"] = false;
			}


			return view("front.quotations.search_results")->with($parameters);

		}
		else
			return view("front.quotations.search_results")->with($parameters);
	}


	/**
	 * Solicitud POST enviada por ajax desde /cotizar/<url_code>/
	 * Obtiene las cotizaciones a partir del url_code de una Quotation existente.
	 * Si es la primera vez que se llama, obtiene los precios desde la API de ATV y los guarda en DB.
	 * Las siguientes veces lo obtiene de la DB.
	 * 
	 * @param  Request $request 	debe contener 'url_code'
	 * @return string           JSON con respuesta
	 */
	public function obtainQuotedProducts(Request $request)
	{

		$response = ["success" => false];

		if($request->has("url_code", "lang") && in_array($request->lang, config("app.langs")))
		{

			\App::setLocale($request->lang);

			if($quotation = Quotation::findByUrlCode($request->url_code))
			{

				if(!$quotation->expired() && $quotation->contract_id == null)
				{

					if(!$quotation->quoted)
					{
						if(!$quotation->saveQuotationProductsFromATV())
						{
							$response["error_text"] = "Problem loading products from the resource.";
							return $response;
						}
					}

					$response["date_from"] = \App\Library\Dates::translate($quotation->date_from);
					$response["date_to"] = \App\Library\Dates::translate($quotation->date_to);
					$response["country_from"] = __($quotation->country_from->name_english);
					$response["region_to"] = ATV::getRegionName($quotation->destination_region_code);
					$response["passenger_count"] = $quotation->passenger_ammount;
					$response["products"] = $quotation->products()->get()->toArray();
					$response["success"] = true;
				}

			}

		}

		return $response;
	}


	/**
	 * Obtiene los montos de cobertura de un QuotationProduct en particular. Si nunca se obtuvieron, se obtienen via API, sino, se obtienen de la DB.
	 * @param  Request $request
	 * @return [type]           [description]
	 */
	public function obtainQuotProductCoverage(Request $request)
	{
		$response = ["success" => false];

		if($request->has(["quot_url_code", "product_atv_id"]))
		{
			if($quotation = Quotation::findByUrlCode($request->quot_url_code))
			{

				$quotationProduct = $quotation->products()->where("product_atv_id", $request->product_atv_id)->first();

				if($quotationProduct != null)
				{

					if($quotationProduct->coverage_details_json == null)
						$quotationProduct->fetchAndSaveCoverageDetails(ATV::getLocale($quotation->lang));


					$response["success"] = true;
					$response["coverage"] = json_decode($quotationProduct->coverage_details_json, true);

				}
				else
					$response["error"] = "Product not found";
			}
			else
				$response["error"] = "Quotation not found";
		}
		else
			$response["error"] = "Data not provided";

		return $response;
	}



}
