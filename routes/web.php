<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





/***************************** BACK OFFICE ***********************************/
 

Route::domain("backoffice.".config("app.domain"))->group(function() {
	Auth::routes();
});



Route::domain("backoffice.".config("app.domain"))->middleware(["auth"])->group(function() {

	Route::get("", "Admin\HomeController@index");

	Route::get("account", "Admin\UserPanelController@show");
	Route::post("account", "Admin\UserPanelController@update");

	Route::get("quotations", "Admin\QuotationController@list");
	Route::get("quotations/{id}", "Admin\QuotationController@details");

	Route::get("contracts", "Admin\ContractController@list");
	Route::get("contracts/{id}", "Admin\ContractController@details");
	Route::post("contracts/{id}/note", "Admin\ContractController@updateNote");
	//Route::post("contracts/{id}/cancel", "Admin\ContractController@cancel");

	Route::get("settings", "Admin\SettingsController@show");
	Route::post("settings", "Admin\SettingsController@update");

});






/***************************** FRONT OFFICE ***********************************/

Route::domain(config("app.domain"))->group(function() {



	//*** URLS sin traducción ****//


	Route::get("lang", "HomeController@changeLanguage");

	// Obtener cotizaciones
	Route::post("quotation/getquotation", "QuotationController@obtainQuotedProducts"); // ajax
	Route::post("quotation/getproductcoverage", "QuotationController@obtainQuotProductCoverage"); //  ajax

	// Procesamiento formulario contratación
	Route::post("contract", "ContractController@processContractForm");

	// Resultado pago mercadopago y paypal (a donde se redirige el cliente después de pagar)
	Route::get("contract/payment/mercadopago", "ProcessPaymentController@processMercadoPagoPayment");
	Route::get("contract/payment/paypal", "ProcessPaymentController@processPayPalPayment");



	// Aplicar lenguaje alternativo (si hay prefijo en URL)
	if( in_array(Request::segment(1), array_diff(Config::get("app.langs"), [Config::get("app.locale")]) ) )
	{
		App::setLocale(Request::segment(1));
		Config::set("app.locale_prefix", Request::segment(1));
	}

	// Registramos sinónimos para rutas traducidas
	foreach(Lang::get("routes") as $k => $v) {
		Route::pattern($k, $v);
	}


	Route::group(array("prefix" => Config::get("app.locale_prefix")), function() {

		
		Route::get("/", "HomeController@index");
		Route::get("{support}", "HomeController@support");
		Route::post("{support}", "HomeController@sendContactForm");

		// Crear cotización
		Route::post("quotation/create", "QuotationController@createQuotation");
		// Ver cotización
		Route::get("{quote}/{url_code}", "QuotationController@displayQuotation");

		// Formulario contratación
		Route::get("{contract}/{quot_url_code}/{quotproduct_atvid}", "ContractController@showContractForm");

		// Página de la contratación una vez generada, donde se puede ver el estado de la misma, pagar si no se pagó, y ver instrucciones una vez pagada.
		Route::get("{contract}/{contract_number}", "ContractController@viewContractDetails");


	});



});

