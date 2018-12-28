<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Library\AseguratuViaje\ATV;

use \App\QuotationProduct;
use \App\Currency;

use anlutro\LaravelSettings\SettingStore;



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

    	$repetitions = self::where('url_code', $new_code)->count();

    	if($repetitions > 0)
    		return self::generateUrlCode();
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
     * Devuelve CSV de edades a partir de edades
     * @param int $ammount  limite superior de edades
     * @param  int ...$ages edades
     * @return string   csv edades
     */
    public static function agesToCsv($limit, ...$ages)
    {
        $csv = "";
        for($i=0; $i<sizeof($ages); $i++) 
        {
            if($i >= $limit)
                break;
            $csv .= $ages[$i].",";
        }

        if(strlen($csv) > 0)
            $csv = substr($csv, 0, -1);

        return $csv;
    }

    
    /**
     * Da un array de edades dado un CSV
     * @param  string $ages_csv    csv de edades
     * @param  int $lower_limit     minima cantidad de elementos a devolver (los que no se proporcionan son cero)
     * @return array              edades
     */
    public static function agesCsvToArray($ages_csv, $lower_limit)
    {
        $ages = array_map("intval", explode(",", $ages_csv));
        return array_pad($ages, $lower_limit, 0);
    }


    /**
     * Devuelve un monto tal que si se le resta el porcentaje $percentage se obtiene $ammount
     * @param float $ammount
     * @param float $percentage     porcentaje 0-100
     */
    public static function addPercentage2($ammount, $percentage)
    {
        return round(100 * $ammount / (100 - $percentage), 2);
    }


    /**
     * Calcula precios de venta de un determinado producto a partir de su costo.
     * @param  float $cost          costo final
     * @param  float $gross_cost    costo sin descuento
     * @param  string $currency_code codigo de moneda
     * @return array                precio de venta final, bruto, y moneda.
     */
    public static function calculateSellingPrices($cost, $gross_cost, $currency_code)
    {

        $profit_margin = setting()->get("profit_margin");


        if($currency_code == "EUR") 
        {

            $prices["price"] = self::addPercentage2(Currency::toUsd($cost, "EUR"), $profit_margin);
            $prices["gross_price"] = self::addPercentage2(Currency::toUsd($gross_cost, "EUR"), $profit_margin);
            $prices["currency"] = "USD";
        }
        else
        {
            $prices["price"] = self::addPercentage2($cost, $profit_margin);
            $prices["gross_price"] = self::addPercentage2($gross_cost, $profit_margin);
            $prices["currency"] = $currency_code;
        }

        return $prices;

    }








    /**
     * Devuelve los productos cotizados asociados a la cotización
     * @return Illuminate\Database\Eloquent\Relations\HasMany   colección de elementos
     */
    public function products()
    {
        return $this->hasMany('App\QuotationProduct');
    }

    /**
     * Obtener un producto de esta cotización con su ID de producto de aseguratuviaje
     * @param  int $product_atv_id
     * @return mixed                 QuotationProduct o null
     */
    public function getProductByAtvId($product_atv_id)
    {
        return $this->products->where("product_atv_id", $product_atv_id)->first();
    }



    public function country_from()
    {
        return $this->belongsTo("App\Country", "origin_country_code", "code_number");
    }


    public function contract()
    {
        return $this->belongsTo("App\Contract");
    }



    /**
     * Obtiene los productos y los precios desde la API de aseguratuviaje.com y los guarda como QuotationProducts en DB
     * Además, asigna el token a la Quotation y la marca como cotizada.
     * Se debe llamar para una Quotation sólo una vez
     * 
     * @return boolean  success
     */
    public function saveQuotationProductsFromATV()
    {

        $ages = self::agesCsvToArray($this->passenger_ages, 5);
        
        $response = ATV::obtainQuotedProducts(
            $this->origin_country_code,
            $this->destination_region_code,
            $this->trip_type_code,
            $this->date_from,
            $this->date_to,
            $ages[0], $ages[1], $ages[2], $ages[3], $ages[4],
            ATV::getLocale($this->lang),
            $this->customer_email,
            $this->gestation_weeks
        );


        if($response == false)
            return false;
        

        foreach($response["Productos"] as $product)
        {

            $prices = self::calculateSellingPrices($product["real_cost"], $product["real_gross_cost"], $product["real_cost_currency"]);

            QuotationProduct::create([
                "quotation_id" => $this->id,
                "img_url" => $product["UrlIMG"],
                "provider_name" => $product["Proveedor"],
                "provider_atv_id" => $product["ProveedorId"],
                "product_atv_id" => $product["ProductoId"],
                "product_name" => $product["Producto"],
                "terms_url" => $product["Condiciones"],
                "disease_insured_amt" => $product["CoberturaEnfermedad"] != null ? $product["CoberturaEnfermedad"] : "",
                "accident_insured_amt" => $product["CoberturaAccidente"] != null ? $product["CoberturaAccidente"] : "",
                "baggage_insured_amt" => $product["CoberturaEquipaje"] != null ? $product["CoberturaEquipaje"] : "",
                "coverage_details_json" => null,
                "cost" => $product["real_cost"],
                "gross_cost" => $product["real_gross_cost"],
                "cost_currency_code" => $product["real_cost_currency"],
                "price" => $prices["price"],
                "gross_price" => $prices["gross_price"],
                "price_currency_code" => $prices["currency"]
            ]);

        }

        $this->atv_token = ATV::lastToken();
        $this->quoted = true;
        $this->save();

        return true;
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


    public function ageEnum()
    {
        $enum = "";
        foreach(self::agesCsvToArray($this->passenger_ages, 0) as $age) {
            $enum .= $age." años, ";
        }
        return substr($enum, 0, -2);
    }


}
