<?php


namespace App\Library;

/*
 * Class used to obtain insurance prices through Aseguratuviaje.com API
 */

class AseguratuViajeApi
{


	const SERVICE_URL = "https://sistema.aseguratuviaje.com/webapi18/api/CotizacionSeguroViajero";
	const WEB_SERVICE = "HuqA%2bLIDQY%2be01sm5osCU4KjJD%2bTCNO2c98S%2bUTBt9YrK7IiFVXRqA%3d%3d"; // cambiar


	/**
	 * Mensaje de error en caso que falle obtainInsuranceRates()
	 * @var string
	 */
	private $error_text;


	/**
	 * Token obtenido de la cotización.
	 * @var string
	 */
	private $token;


	/**
	 * Obtiene las cotizaciones desde la API de aseguratuviaje.com a partir de los datos del viaje.
	 * @param  int $paisDesde       codigo pais desde
	 * @param  int $paisHasta       codigo pis hasta
	 * @param  int $tipoViaje       codigo tipo viaje
	 * @param  string $fechaDesde      fecha inicio seguro
	 * @param  string $fechaHasta      fecha fin seguro
	 * @param  int $edad1           
	 * @param  int $edad2           
	 * @param  int $edad3           
	 * @param  int $edad4           
	 * @param  int $edad5           
	 * @param  string $cultura         codigo localizacion
	 * @param  string $email           
	 * @param  int $semanaGestacion [description]
	 * @param  string $source          origen trafico
	 * @return mixed                  FALSE o array con datos
	 */
	public function obtainInsuranceRates($paisDesde, $paisHasta, $tipoViaje, $fechaDesde, $fechaHasta, $edad1, $edad2, $edad3, $edad4, $edad5, $cultura, $email, $semanaGestacion, $source)
	{


		$trip_data = array(

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
			"Source" => $source,
			"Token" => "" // this is the piece of info we need

		);

		$token = $this->getToken($trip_data);

		if(!$token)
			return false;

		return $this->getRates($token);

	}

	/**
	 * Obtiene msg de error
	 * @return string
	 */
	public function error()
	{
		return $this->error_text;
	}


	/**
	 * Devuelve el token obtenido en la última cotización de precios.
	 * @return string
	 */
	public function lastToken()
	{
		return $this->token;
	}


	/**
	 * Obtiene el token de cotizacion desde la API de aseguratuviaje.com
	 * @param  array $trip_data		datos del viaje a cotizar
	 * @return mixed            String del token o FALSE si hay error.
	 */
	private function getToken($trip_data)
	{

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, self::SERVICE_URL);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($trip_data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));

		$response = curl_exec($ch); // devuelve datos o FALSE

		if($response === false) // request failed
		{
			$this->error_text = "Error CURL: " . curl_error($ch);
			curl_close($ch);

			return false;
		}
		else // request success
		{
			$response = json_decode($response, true);
			$response_no = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			if($response_no == 200) // response OK
			{	
				$this->token = $response["Token"];
				return $this->token;
			}
			
			else // response with error
			{
				$this->error_text = "Error obteniendo token. Respuesta: " . $response["Message"];
				return false;
			}
		}
	}


	/**
	 * Obtiene json de productos desde la API de aseguratuviaje.com con el token
	 * @param  string $token Token
	 * @return mixed        String JSON o FALSE si hay error
	 */
	private function getRates($token)
	{
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, self::SERVICE_URL . "?idseguro=0&token=".$token);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17');

		$response = curl_exec($ch); // devuelve datos o FALSE

		if($response === false) // request failed
		{
			$this->error_text = "Error CURL: " . curl_error($ch);
			curl_close($ch);
			return false;
		}
		else // request success
		{
			$response = json_decode($response, true);
			$response_no = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			if($response_no == 200) // response OK
				return $response;
			
			else // response with error
			{
				$this->error_text = "Error obteniendo precios. Respuesta: " . $response["Message"];
				return false;
			}
		}


	}





}