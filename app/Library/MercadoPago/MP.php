<?php

namespace App\Library\MercadoPago;


use \App\MercadoPagoRequest;


class MP
{


    const MP_CLIENT_ID = "6411514145865143"; // credenciales cta daniela682@hotmail.com
    const MP_CLIENT_SECRET = "1iOXdoSLUxy9dyQVsaMyckJwbiVuDjWt";
    const ACCESS_TOKEN = "";

    const MP_CLIENT_ID_TEST = "6838767400124210"; // credenciales cta vendedora test test_user_50902160@testuser.com
    const MP_CLIENT_SECRET_TEST = "5ljVzV6i9k9nW1UMabuYKeyCwaIg0mWz";
    const ACCESS_TOKEN_TEST = "APP_USR-6838767400124210-112618-3b3c111f0486b481eb7a55b1c56e1669-381137003";






	/**
	 * Autenticar con la API de MercadoPago. 
	 * Con client id y client secret es suficiente para generar Preferences (botones de pago) y hacer operaciones como buscar pagos y órdenes.
	 * @return  null
	 */
	public static function APIauth()
	{
		if(config("app.env") == "local")
		{
			\MercadoPago\SDK::setClientId(self::MP_CLIENT_ID_TEST);
			\MercadoPago\SDK::setClientSecret(self::MP_CLIENT_SECRET_TEST);
			//\MercadoPago\SDK::setAccessToken(self::ACCESS_TOKEN_TEST);
		}
		else if(config("app.env") == "production")
		{
			\MercadoPago\SDK::setClientId(self::MP_CLIENT_ID);
			\MercadoPago\SDK::setClientSecret(self::MP_CLIENT_SECRET);
			//\MercadoPago\SDK::setAccessToken("ENV_ACCESS_TOKEN");
		}
	}


	/**
	 * Crear la preferencia con la API SDK de MercadoPago a partir de instancia de MercadoPagoRequest
	 * @param MercadoPagoRequest $mpRequest 	Instancia de obj. de solicitud MercadoPago
	 * @return \MercadoPago\Preference | false
	 */
	public static function createPreference(MercadoPagoRequest $mpRequest, $contract_number)
	{
		try
		{

			self::APIauth();

			$preference = new Preference();

			$item = new \MercadoPago\Item();
			$item->id = $mpRequest->item_id;
			$item->title = $mpRequest->item_title;
			$item->quantity = $mpRequest->item_quantity;
			$item->currency_id = $mpRequest->item_currency_code;
			$item->unit_price = $mpRequest->item_unit_price;

			$payer = new \MercadoPago\Payer();
			$payer->email = $mpRequest->payer_email;
			$payer->name = $mpRequest->payer_name;
			$payer->surname = $mpRequest->payer_surname;
			

			$preference->back_urls = array(
			    "success" => config("app.url")."/contract/payment/mercadopago/",
			    "failure" => config("app.url")."/contract/payment/mercadopago/?ft=".$mpRequest->failure_url_token,
			    "pending" => config("app.url")."/contract/payment/mercadopago/"
			);

			$preference->external_reference = "contratacion #".$contract_number;			
			
			// excluimos boleta de pago y red link (medios de pago lentos)
			$preference->payment_methods = array(
				"excluded_payment_types" => array(
					array("id" => "ticket"),
					array("id" => "atm")
				)
			);

			
			$preference->expires = true;
			$preference->expiration_date_to = $mpRequest->expiration_date;


			$preference->items = array($item);
			$preference->payer = $payer;

			$preference = $preference->save();

			return $preference;

		}
		catch(\Exception $e)
		{
			\Log::notice("Error generando solicitud mercadopago. ".$e->getMessage());
			return false;
		}


	}





}