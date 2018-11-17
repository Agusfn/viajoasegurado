<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationProduct extends Model
{
    

	protected $guarded = [];



	/**
	 * Crea y guarda un producto cotizado a partir del id de cotizacion y el array de datos del producto obtenido desde la API de ATV
	 * @param array $product_data 	array con datos del producto obtenido desde la api cotizadora de atv
	 * @param int $quotation_id 	id de cotización asociada
	 */
	public static function addProductFromApiArray($product_data, $quotation_id)
	{

		$quotationProduct = new Self();

		$quotationProduct->fill([
			"quotation_id" => $quotation_id,
			"img_url" => $product_data["UrlIMG"],
			"provider" => $product_data["Proveedor"],
			"provider_atv_id" => $product_data["ProveedorId"],
			"product_atv_id" => $product_data["ProductoId"],
			"age_from" => $product_data["EdadDesde"],
			"age_to" => $product_data["EdadHasta"],
			"product_name" => $product_data["Producto"],
			"terms_url" => $product_data["Condiciones"],
			"category" => $product_data["Categoria"],
			"bonification" => $product_data["Bonificacion"],
			"discount" => $product_data["Descuento"],
			"type" => $product_data["Tipo"],
			"recommended" => $product_data["Recomendado"],
			"disease_insured_amt" => $product_data["CoberturaEnfermedad"] != null ? $product_data["CoberturaEnfermedad"] : "",
			"accident_insured_amt" => $product_data["CoberturaAccidente"] != null ? $product_data["CoberturaAccidente"] : "",
			"baggage_insured_amt" => $product_data["CoberturaEquipaje"] != null ? $product_data["CoberturaEquipaje"] : "",
			"is_deductible" => $product_data["EsDeducible"],
			"cost" => $product_data["Costo"],
			"gross_cost" => $product_data["CostoBruto"],
			"orig_cost" => $product_data["CostoOrigen"],
			"orig_gross_cost" => $product_data["CostoBrutoOrigen"],
			"currency" => $product_data["Moneda"],
			"currency_atv_id" => $product_data["MonedaId"],
			"passengers_cost" => "",
		]);

		$quotationProduct->save();


	}


}
