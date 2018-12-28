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

}