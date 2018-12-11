<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    

	public static function getByCurrencyCode($currency_code)
	{
		return self::where("currency_code", $currency_code);
	}


}
