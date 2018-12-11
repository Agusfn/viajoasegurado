<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
	public function createQuotation(Request $req)
	{

		// **validar parametros!**

		if($req->has("travel_pregnant"))
		{
			$ages = $req->age1;
			$gest_weeks = $req->gestation_weeks;
		}
		else
		{
			$ages = Quotation::agesToCsv($req->passenger_ammt, $req->age1, $req->age2, $req->age3, $req->age4, $req->age5);
			$gest_weeks = 0;
		}


		$quotation = new Quotation();

		$quotation->fill([
			"expiration_date" => date("Y-m-d H:i:s", strtotime("+3 hour")),
			"customer_email" => $req->email,
			"origin_country_code" => $req->country_from_id,
			"destination_region_code" => $req->region_to_id,
			"trip_type_code" => $req->trip_type,
			"date_from" => $req->date_from,
			"date_to" => $req->date_to,
			"passenger_ammount" => $req->passenger_ammt,
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
		
		if($request->url_code != null && $quotation = Quotation::findByUrlCode($request->url_code))
		{

			if($quotation->expired() || $quotation->contract_id != null) // si expiró o ya se generó una contratación
				$quotationExpired = true;
			else
				$quotationExpired = false;


			return view("frontoffice.quotations.show_options")->with([
				"quotationFound" => true,
				"quotationExpired" => $quotationExpired,
				"url_code" => $quotation->url_code
			]);

		}
		else
			return view("frontoffice.quotations.show_options")->with("quotationFound", false);
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

		if($request->has("url_code"))
		{

			if($quotation = Quotation::findByUrlCode($request->url_code))
			{

				if(!$quotation->expired() && $quotation->contract_id == null)
				{

					if(!$quotation->quoted)
						$quotation->saveQuotationProductsFromATV();
										
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

			}
		}

		return $response;
	}



}
