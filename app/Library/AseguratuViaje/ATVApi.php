<?php

namespace App\Library\AseguratuViaje;

/*
 * Class used to obtain insurance prices through Aseguratuviaje.com API
 */

class ATVApi
{


	/**
	 * Código identificador de afiliado de aseguratuviaje.com
	 */
	const WEB_SERVICE = "yvZQ9KoVO+GSRytsjn6RfqDDcLzz1E7qzQvxJJTqPO302JLjuzkVMhchNNzalC7Y"; 
	//const WEB_SERVICE = "HuqA%2bLIDQY%2be01sm5osCU4KjJD%2bTCNO2c98S%2bUTBt9YrK7IiFVXRqA%3d%3d";	// este el público, cambiar despues

	/**
	 * Mensaje de error en caso que falle obtainQuotedProducts()
	 * @var string
	 */
	private static $error_text;


	/**
	 * Codigo de respuesta http de ultima solicitud
	 * @var int
	 */
	private static $req_response_code;

	
	/**
	 * Obtiene el token de cotizacion desde la API de aseguratuviaje.com
	 * 
	 * @param  int $paisDesde       Cod pais desde (en config Config::get("custom.insurances.regions_to"))
	 * @param  int $paisHasta       Cod region hasta (en config Config::get("custom.insurances.regions_to"))
	 * @param  int $tipoViaje       Cod tipo viaje (en config Config::get("custom.insurances.trip_types"))
	 * @param  string $fechaDesde      Y-m-d
	 * @param  string $fechaHasta      Y-m-d
	 * @param  int $edad1           edad 1er pasajero (obligatoria)
	 * @param  int $edad2           edad ó 0
	 * @param  int $edad3           edad ó 0
	 * @param  int $edad4           edad ó 0
	 * @param  int $edad5           edad ó 0
	 * @param  string $cultura         "es-ES" o "en-US"
	 * @param  string $email           mail interesado
	 * @param  int $semanaGestacion 	Si no embarazada 0, si embarazada, solo debe haber edad1.
	 * @return string|false 		token
	 */
	public static function getToken($paisDesde, $paisHasta, $tipoViaje, $fechaDesde, $fechaHasta, $edad1, $edad2, $edad3, $edad4, $edad5, $cultura, $email, $semanaGestacion)
	{

		$trip_data = [
			"PaisDesde" => $paisDesde,
			"PaisHasta" => $paisHasta,
			"TipoViaje" => $tipoViaje,
			"FechaDesde" => $fechaDesde,
			"FechaHasta" => $fechaHasta,
			"Edad1" => $edad1,
			"Edad2" => $edad2,
			"Edad3" => $edad3,
			"Edad4" => $edad4,
			"Edad5" => $edad5,
			"Cultura" => $cultura,
			"Email" => $email,
			"WebService" => self::WEB_SERVICE,
			"SemanaGestacion" => $semanaGestacion,
			"Source" => "", // origen tráfico
			"Token" => "" // this is the piece of info we need
		];

		$response = self::makeRequest("POST", "https://sistema.aseguratuviaje.com/webapi18/api/CotizacionSeguroViajero", $trip_data);

		if($response === false)
			return false;

		if(self::$req_response_code == 200) {
			return $response["Token"];
		}
		else {	
			self::$error_text = "Error obteniendo token ATV Api. Respuesta: " . $response["Message"];
			\Log::notice(self::$error_text);
			return false;
		}

	}


	/**
	 * Obtiene json de productos desde la API de aseguratuviaje.com con el token
	 * @param  string $token
	 * @return mixed        String JSON o FALSE si hay error
	 */
	public static function getQuotedProductsInfo($token)
	{
		
		$response = self::makeRequest("GET", "https://sistema.aseguratuviaje.com/webapi18/api/CotizacionSeguroViajero?idseguro=0&token=".$token);

		if($response === false)
			return false;

		if(self::$req_response_code == 200)
			return $response;
		else
		{
			self::$error_text = "Error obteniendo precios ATV Api. Respuesta: " . $response["Message"];
			\Log::notice(self::$error_text);
			return false;
		}

	}


	/**
	 * Obtiene la cobertura
	 * @param  [type] $locale         [description]
	 * @param  [type] $product_atv_id [description]
	 * @return mixed                 FALSE o array rta
	 */
	public static function getProductCoverage($locale, $product_atv_id)
	{
		$post_data = [
			"idcultura" => $locale, // Sólo funcionan ALGUNOS. Averiguar bien cuales. Español: es-ES
			"idseguros" => [
				$product_atv_id
			]
		];

		$response = self::makeRequest("POST", "https://sistema.aseguratuviaje.com/webapi18/api/Cobertura", $post_data);

		if($response === false)
			return false;

		if(self::$req_response_code == 200)
			return $response;
		else
		{
			self::$error_text = "Http resp code ".self::$req_response_code." obtaining product coverage details in ATV Api";
			\Log::notice(self::$error_text);
			return false;
		}
	}



	/**
	 * Obtiene msg de error
	 * @return string
	 */
	public static function error()
	{
		return self::$error_text;
	}




	/**
	 * Hacer solicitud http POST o GET.
	 * @param  string $method      "POST" o "GET"
	 * @param  string $url
	 * @param  array  $post_fields
	 * @return mixed              FALSE o array de respuesta json decoded
	 */
	private static function makeRequest($method, $url, $post_fields = [])
	{
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');

		if($method == "POST") 
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
		}

		$response = curl_exec($ch); // devuelve datos o FALSE

		if($response !== false) // success
		{
			self::$req_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			if(config("app.debug")) {
			\Log::info("(ATV API) ".$method." request to ".$url.", fields: ".json_encode($post_fields).". Response code: ".self::$req_response_code/*."\r\n".$response*/);
			}

			return json_decode($response, true);
		}
		else // failed
		{
			self::$error_text = curl_error($ch);
			\Log::notice("Error realizando solicitud http CURL en makeRequest() en ATVApi. Texto: ".self::$error_text);
			curl_close($ch);
			return false;
		}


	}




}