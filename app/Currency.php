<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Currency extends Model
{
    
    /**
     * IDs de moneda de aseguratuviaje y sus respectivos códigos de moneda.
     */
    private static $atv_id_currencies = [
    	1 => "EUR",
    	2 => "ARS",
    	3 => "USD"
    ];

    /**
     * Devuelve código de moneda a partir de id de moneda de aseguratuviaje.
     * @param  int $atv_id
     * @return string|null
     */
	public static function codeFromAtvId($atv_id)
	{
		if(isset(self::$atv_id_currencies[$atv_id]))
			return self::$atv_id_currencies[$atv_id];
		else
			return null;
	}


    /**
     * Convertir una moneda a USD
     * @param  [type] $ammount       [description]
     * @param  [type] $currency_from [description]
     * @return [type]                [description]
     */
    public static function toUsd($ammount, $currency_from)
    {
        $key = "usd_to_".strtolower($currency_from)."_rate";

        if(!setting()->has($key))
            return false;

        $usd_to_x = setting($key);

        return $ammount / $usd_to_x;

    }


}
