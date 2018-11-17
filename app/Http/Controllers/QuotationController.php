<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;

class QuotationController extends Controller
{
    
    /**
     * Crea una nueva cotización (sin cotizar aun) enviando desde el formulario cotizador.
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function createQuotation(Request $request)
	{


		$quotation = new Quotation();

		$quotation->fill([
			"expiration_date" => date("Y-m-d H:i:s", strtotime("+3 hour")),
			"customer_email" => $request->email,
			"origin_country_code" => $request->pais_desde,
			"destination_region_code" => $request->pais_hasta,
			"trip_type_code" => $request->tipo_viaje,
			"date_from" => $request->fecha_desde,
			"date_to" => $request->fecha_hasta,
			"passenger_ammount" => $request->cant_pasaj,
			"passenger_ages" => $request->edades,
			"gestation_weeks" => $request->semana_gestacion,
			"url_code" => Quotation::generateUrlCode(),
			"customer_lang" => "es",
			"customer_country" => "AR",
			"customer_ip" => request()->ip(),
			"atv_token" => "",
			"quoted" => false,
			"contracted" => false
		]);

		$quotation->save();

		return redirect("cotizar/".$quotation->url_code);
	}


	/**
	 * Dirige la página donde se muestran las cotizaciones
	 * @param  [type] $url_id [description]
	 * @return [type]         [description]
	 */
	public function displayQuotation($url_code)
	{
	

		if($quotation = Quotation::findByUrlCode($url_code))
		{

			if($quotation->expired())
				$quotationExpired = true;
			else
				$quotationExpired = false;


			$data = [
				"quotationFound" => true,
				"quotationExpired" => $quotationExpired,
				"url_code" => $url_code
			];

			return view("quotations.show_options")->with($data);

		}
		else
			return view("quotations.show_options")->with("quotationFound", false);
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
	public function obtainQuotationOptions(Request $request)
	{

		$response = ["success" => false];

		if($request->url_code != null)
		{

			if($quotation = Quotation::findByUrlCode($request->url_code))
			{

				if(!$quotation->expired())
				{

					if(!$quotation->quoted)
						$quotation->saveQuotationProductsFromATV();
										
					$products = $quotation->products()->get()->toArray(); // INCNLUYE INFO IMPORTANTE Q NO HAY Q MANDAR
					$response["products"] = $products;
					$response["success"] = true;
					
				}

			}

		}

		return $response;
	}



    public function cotizador()
    {
    	return view("form");
    }

}
