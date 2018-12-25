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
 

Route::domain("backoffice.".env("APP_DOMAIN"))->group(function() {
	Auth::routes();
});

Route::domain("backoffice.".env("APP_DOMAIN"))->middleware(["auth"])->group(function() {

	Route::get("", "AdminPanelController@home");
	Route::get("quotations", "AdminPanelController@quotationList");
	Route::get("contracts", "AdminPanelController@contractList");
	Route::get("settings", "AdminPanelController@settings");

	Route::get("quotations/{id}", "AdminPanelController@quotationDetails");
	Route::get("contracts/{id}", "AdminPanelController@contractDetails");


});






/***************************** FRONT OFFICE ***********************************/


//*** URLS sin traducción ****//


Route::get("lang", "homeController@changeLanguage");

// Obtener cotizaciones
Route::post("quotation/getquotation", "QuotationController@obtainQuotedProducts"); // ajax
Route::post("quotation/getproductcoverage", "QuotationController@obtainQuotProductCoverage"); //  ajax


// Procesamiento formulario contratación
Route::post("contract", "ContractController@processContractForm");


// Resultado pago mercadopago y paypal (a donde se redirige el cliente después de pagar)
Route::get("contract/payment/mercadopago", "ProcessPaymentController@processMercadoPagoPayment");
Route::get("contract/payment/paypal", "ProcessPaymentController@processPayPalPayment");



Route::get("search_demo", "HomeController@searchdemo");


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

	// Crear cotización
	Route::post("quotation/create", "QuotationController@createQuotation");
	// Ver cotización
	Route::get("{quote}/{url_code}", "QuotationController@displayQuotation");

	// Formulario contratación
	Route::get("{contract}/{quot_url_code}/{quotproduct_atvid}", "ContractController@showContractForm");

	// Página de la contratación una vez generada, donde se puede ver el estado de la misma, pagar si no se pagó, y ver instrucciones una vez pagada.
	Route::get("{contract}/{contract_number}", "ContractController@viewContractDetails");



});