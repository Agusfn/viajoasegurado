<?php

namespace App\Library\AseguratuViaje;

use App\Currency;

/**
 * Clase que maneja la clase de la API de aseguratuviaje y la lógica de los datos proporcionados por la misma.
 */
class ATV
{


	/**
	 * Procentaje de comisión pre-fijada por aseguratuviaje, no es la comisión real que se cobra después.
	 * Se usa para obtener el costo de cada producto a partir del supuesto precio de venta que asumen que vamos a vender.
	 */
	const ATV_COMMISSION = 15;


	private static $last_token;


	/**
	 * Obtiene productos cotizados desde la API de aseguratuviaje.com a partir de los datos del viaje.
	 * 
	 * @param  int $paisDesde       Cod pais desde (en Config::get("custom.insurances.regions_to"))
	 * @param  int $paisHasta       Cod region hasta (en Config::get("custom.insurances.regions_to"))
	 * @param  int $tipoViaje       Cod tipo viaje (en Config::get("custom.insurances.trip_types"))
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
	 * @return mixed                  FALSE o array con datos
	 */
	public static function obtainQuotedProducts($paisDesde, $paisHasta, $tipoViaje, $fechaDesde, $fechaHasta, $edad1, $edad2, $edad3, $edad4, $edad5, $cultura, $email, $semanaGestacion)
	{

		$token = ATVApi::getToken(
			$paisDesde, 
			$paisHasta, 
			$tipoViaje,
			$fechaDesde, 
			$fechaHasta, 
			$edad1, 
			$edad2, 
			$edad3, 
			$edad4, 
			$edad5, 
			$cultura, 
			$email, 
			$semanaGestacion
		);

		if(!$token)
			return false;

		self::$last_token = $token;

		$quoteResponse = ATVApi::getQuotedProductsInfo($token);

		if(!$quoteResponse)
			return false;



		/* Agregamos a cada producto información del costo real y su respectiva moneda */

		for($i=0; $i<sizeof($quoteResponse["Productos"]); $i++)
		{
			
			$product = $quoteResponse["Productos"][$i];

			if(in_array($paisDesde, [32, 724])) // para seguros desde ARG y ESP nos cobran en su moneda local
			{
				$quoteResponse["Productos"][$i]["real_cost"] = self::substractCommission($product["CostoOrigen"]);
				$quoteResponse["Productos"][$i]["real_gross_cost"] = self::substractCommission($product["CostoBrutoOrigen"]);
				$quoteResponse["Productos"][$i]["real_cost_currency"] = Currency::codeFromAtvId($quoteResponse["PaisOrigen"]["Moneda"]["id"]);
			}
			else // el resto podemos pagarlo en USD
			{
                $quoteResponse["Productos"][$i]["real_cost"] = self::substractCommission($product["Costo"]);
                $quoteResponse["Productos"][$i]["real_gross_cost"] = self::substractCommission($product["CostoBruto"]);
                $quoteResponse["Productos"][$i]["real_cost_currency"] = Currency::codeFromAtvId($product["MonedaId"]);
			}

		}


		return $quoteResponse;

	}


	/**
	 * Resta porcentaje de comisión (pre-fijada por aseguratuviaje, es decir, no es la comisión real) al monto con comisión incluida.
	 * @param  float 	$ammount
	 * @return float    costo sin comisión
	 */
	private static function substractCommission($ammount)
	{
		return round($ammount * ((100 - self::ATV_COMMISSION)/100), 2);
	}


	/**
	 * [lastToken description]
	 * @return [type] [description]
	 */
	public static function lastToken()
	{
		return self::$last_token;
	}




	/**
	 * Devuelve código locale (ej: es-AR) apropiado para enviar a la API a partir de cód de lenguaje ISO 639-1
	 * Se hace porque la api soporta pocos codigos de localizacion.
	 * 
	 * @param  string 	$lang 	Cód lenguaje ISO 639-1
	 * @return string
	 */
	public static function getLocale($lang)
	{
		if($lang == "es")
			return "es-ES";
		else if($lang == "en")
			return "en-US";
	}



	/**
	 * Obtiene nombre de región de destino (traducido)
	 * @param  int $code codigo de region (en config.custom.insurances)
	 * @return string       nombre de la region
	 */
	public static function getRegionName($code)
	{
		$regions_to = \Config::get("custom.insurances.regions_to");

		foreach($regions_to as $region)
		{
			if($region["id"] == $code)
				return __($region["name"]);
		}
		return false;
	}




	/**
	 * Obtiene lista de países (con nombre traducido y codigo) de origen soportados por aseguratuviaje.
	 * @param boolean $orderByName	ordenar lista por nombre de país
	 * @return array de arrays con codigo y nombre de paises
	 */
	public static function getCountriesFrom($orderByName = true)
	{
        $countries_from = \Config::get("custom.insurances.countries_from");


        if(!\App::isLocale("en"))
        {  
            for($i=0; $i<sizeof($countries_from); $i++) {
                $countries_from[$i]["name"] = __($countries_from[$i]["name"]);
            }
        }

        if($orderByName)
        {
	        usort($countries_from, function ($item1, $item2) {
            	return $item1['name'] <=> $item2['name'];
       		});
        }

        return $countries_from;
	}



	/**
	 * Obtiene lista de regiones (con nombre traducido y codigo atv) de destino soportadas por aseguratuviaje.
	 * @return array de arrays con codigo y nombre de paises
	 */
	public static function getRegionsTo()
	{
        $regions_to = \Config::get("custom.insurances.regions_to"); // paises y regiones vienen en ingles

        if(!\App::isLocale("en"))
        {
            for($i=0; $i<sizeof($regions_to); $i++) {
                $regions_to[$i]["name"] = __($regions_to[$i]["name"]);
            }
        }

        return $regions_to;
	}

}