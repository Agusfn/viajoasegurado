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
	 * @return mixed                  FALSE o array con datos
	 */
	public static function obtainQuotedProducts($paisDesde, $paisHasta, $tipoViaje, $fechaDesde, $fechaHasta, $edad1, $edad2, $edad3, $edad4, $edad5, $cultura, $email, $semanaGestacion)
	{

		/* Obtenemos productos */

		$token = ATVApi::getToken($paisDesde, $paisHasta, $tipoViaje, $fechaDesde, $fechaHasta, $edad1, $edad2, $edad3, $edad4, $edad5, $cultura, $email, $semanaGestacion, "");

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
	public static function substractCommission($ammount)
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


}