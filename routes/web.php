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

/*Route::get('/', function () {
    return view('test');
});*/



Route::get("/", "QuotationController@cotizador");



Route::post("cotizar", "QuotationController@createQuotation");
Route::get("cotizar/{url_code}", "QuotationController@displayQuotation");
Route::post("cotizar/obtener", "QuotationController@obtainQuotationOptions");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



// admin
Route::get("backoffice/cotizaciones", "AdminPanelController@showQuotations");
Route::get("backoffice/cotizaciones/{id}", "AdminPanelController@quotationDetails");