<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Library\AseguratuViajeApi;
use \App\QuotationProduct;

class Quotation extends Model
{

    protected $guarded = [];



    /**
     * Genera codigo url único y lo devuelve.
     * @return String
     */
    public static function generateUrlCode()
    {

    	$new_code = str_random(32);
    	//$new_code = "hola";

    	$repetitions = self::where('url_code', $new_code)->count();

    	//echo [$new_code, $number];

    	if($repetitions > 0)
    		return $this->generateUrlCode();
    	else
    		return $new_code;

    }


    /**
     * Busca Quotation por url_code
     * @param  string $url_code
     * @return mixed           Instancia de Cotizacion o null.
     */
    public static function findByUrlCode($url_code)
    {
    	return self::where('url_code', $url_code)->first();
    }


    /**
     * Devuelve los productos cotizados asociados a la cotización
     * @return Illuminate\Database\Eloquent\Relations\HasMany	colección de elementos
     */
    public function products()
    {
    	return $this->hasMany('App\QuotationProduct');
    }



    /**
     * Obtiene los productos y los precios desde la API de aseguratuviaje.com y los guarda como QuotationProducts en DB
     * Además, asigna el token a la Quotation y la marca como cotizada.
     * Se debe llamar para una Quotation sólo una vez
     * 
     * @return boolean	success
     */
    public function saveQuotationProductsFromATV()
    {

    	$atvApi = new AseguratuViajeApi();

		$ages = $this->getPassengerAgeArray();

    	$response = $atvApi->obtainInsuranceRates(
    		$this->origin_country_code,
    		$this->destination_region_code,
    		$this->trip_type_code,
    		$this->date_from,
    		$this->date_to,
    		$ages[0], $ages[1], $ages[2], $ages[3], $ages[4],
    		$this->customer_lang."-".$this->customer_country,
    		$this->customer_email,
    		$this->gestation_weeks,
    		""
    	);

    	if($response == false)
    		return false;
    	

    	$productos = $response["Productos"];

    	foreach($productos as $producto)
    	{
    		QuotationProduct::addProductFromApiArray($producto, $this->id);
    	}


    	$this->atv_token = $atvApi->lastToken();
		$this->quoted = true;
		$this->save();    	
    }



    /**
     * Devuelve un array de 5 numeros de las edades de cada pasajero. Si hay menos de 5 pasajeros, los valores de los que no existen son cero.
     * @return int[]
     */
    public function getPassengerAgeArray()
    {
    	$ages = explode(",", $this->passenger_ages);
    	return array_pad($ages, 5, 0);
    }


    /**
     * Verifica si la cotización expiró
     * @return boolean
     */
    public function expired()
    {
		$now = new \DateTime();
		$expiration = new \DateTime($this->expiration_date);

		if($expiration > $now)
			return false;
		else
			return true;
    }


}
