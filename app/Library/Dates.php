<?php

namespace App\Library;


class Dates
{

	// date en YYYY-MM-DD
	// arroja 2 dic 2018, 5th Dec 2019
	public static function translate($date)
	{
		$time = strtotime($date);

		if(\App::isLocale("en"))
			return date("jS M Y", $time);

		else if(\App::isLocale("es"))
			return date("j", $time)." ".__(strtolower(date("M", $time)))." ".date("Y", $time);

	}


	/**
	 * Obtiene cantidad de días entre 2 fechas
	 * @param  string $start YYYY-MM-DD
	 * @param  string $end   YYYY-MM-DD
	 * @return int        cant dias
	 */
	public static function diffDays($start, $end)
	{
		return intval((new \DateTime($start))->diff(new \DateTime($end))->format("%a")) + 1;
	}

}