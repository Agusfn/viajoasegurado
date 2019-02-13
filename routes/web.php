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
	Route::post("contracts/{id}/complete", "Admin\ContractController@markVoucherSent");
	//Route::post("contracts/{id}/cancel", "Admin\ContractController@cancel");

	Route::get("settings", "Admin\SettingsController@show");
	Route::post("settings", "Admin\SettingsController@update");


	Route::get("users", "Admin\UsersController@list");
	Route::get("users/new", "Admin\UsersController@new");
	Route::post("users/create", "Admin\UsersController@create");
	Route::get("users/{id}", "Admin\UsersController@details");
	Route::post("users/{id}", "Admin\UsersController@update");
	Route::post("users/{id}/delete", "Admin\UsersController@delete");

});






/***************************** FRONT OFFICE ***********************************/

Route::domain(config("app.domain"))->group(function() {



	//*** URLS sin traducción ****//


	Route::get("lang", "HomeController@changeLanguage");

	// Obtener cotizaciones
	Route::post("quotation/getquotation", "QuotationController@obtainQuotedProducts"); // ajax
	Route::post("quotation/getproductcoverage", "QuotationController@obtainQuotProductCoverage"); //  ajax	

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
		Route::get("{insurer}/{insurer_name}", "HomeController@insurerDetails");
		Route::get("{insurance}/{insurance_type}", "HomeController@insuranceTypeDetails");
		Route::get("{about_us}", "HomeController@aboutUs");
		Route::get("{terms}", "HomeController@showTermsAndConditions");

		Route::post("quotation/create", "QuotationController@createQuotation");
		Route::get("{quote}/{url_code}", "QuotationController@displayQuotation");

		Route::post("{contract}", "ContractController@processContractForm");
		Route::get("{contract}/{quot_url_code}/{quotproduct_atvid}", "ContractController@showContractForm");
		Route::get("{contract}/{contract_number}", "ContractController@viewContractDetails");

	});



});

