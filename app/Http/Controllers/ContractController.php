<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Http\Requests\CreateContract;

use \App\Contract;
use \App\Quotation;
use \App\QuotationProduct;
use \App\PaymentMethod;

use \App\MercadoPagoRequest;
use \App\PaypalRequest;

use \App\Library\AseguratuViaje\ATV;



class ContractController extends Controller
{
    

	/**
	 * Verifica validez de cotizacion y luego muestra formulario contratacion.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function showContractForm(Request $request)
	{
		$parameters = [
			"validContract" => false
		];
		
		if($quotation = Quotation::findByUrlCode($request->quot_url_code))
		{
			
			if(!$quotation->expired())
			{

				if($quotation->contract_id != null) {
					return redirect(uri_localed("{contract}/".$quotation->contract->number));
				}


				$quotationProduct = $quotation->getProductByAtvId($request->quotproduct_atvid);

				if($quotationProduct != null)
				{

					if($quotationProduct->coverage_details_json == null)
						$quotationProduct->fetchAndSaveCoverageDetails(ATV::getLocale($quotation->lang));

					$parameters = [
						"validContract" => true,
						"quotation" => $quotation, 
						"product" => $quotationProduct, 
						"product_coverage" => json_decode($quotationProduct->coverage_details_json, true)
					];
				}

			}

		}


		return view("front.contract.form")->with($parameters);


	}



	/**
	 * Procesa formulario contratacion.
	 * 1) Valida datos
	 * 2) Verifica validez Quotation y QuotationProduct
	 * 3) Crea Contract con datos de la contratacion.
	 * 4) Genera solicitud de pago
	 * 5) Guarda datos y redirige.
	 * 
	 * @param  CreateContract $request [description]
	 * @return [type]                  [description]
	 */
	public function processContractForm(CreateContract $request)
	{
		$request->validated();
		
		$quotation = Quotation::findByUrlCode($request->quotation_code);

		if($quotation == null)
			return view("front.contract.error")->with("error", "other");

		if($quotation->expired() || $quotation->contract_id != null)
			return view("front.contract.error")->with("error", "expired");


		for($i=1; $i<=$quotation->passenger_ammount; $i++) 
		{
			if(!$request->filled("passg".$i."_name", "passg".$i."_surname", "passg".$i."_document", "passg".$i."_birthdate"))
				return redirect()->back()->withErrors('Input all the passenger information.');
		}

		if($quotation->origin_country_code == 32) // ARG
		{ 
			if(!$request->filled("billing_fiscal_condition", "billing_fullname", "billing_tax_number", "billing_address_street", "billing_address_number", "billing_address_city", "billing_address_zip", "billing_address_state")) {
				return redirect()->back()->withErrors('Input all the billing information.');
			}
		}


		$quotationProduct = $quotation->getProductByAtvId($request->quotationproduct_atvid);

		if($quotationProduct == null)
			return view("front.contract.error")->with("error", "other");



		$passg_details = [null, null, null, null, null, null];
		for($i=1; $i<=$quotation->passenger_ammount; $i++) {
			$date = date_create_from_format('d/m/Y', $request->{"passg".$i."_birthdate"});
			$passg_details[$i] = $request->{"passg".$i."_name"}.",".$request->{"passg".$i."_surname"}.",".$request->{"passg".$i."_document"}.",".date_format($date, 'Y-m-d');;
		}

		
		$contract = Contract::create([
			"number" => Contract::randomNumber(),
			"current_status_id" => 0,
			"quotation_id" => $quotation->id,
			"quotation_product_id" => $quotationProduct->id,
			"active_payment_req_id" => null,
			"beneficiary_1" => $passg_details[1],
			"beneficiary_2" => $passg_details[2],
			"beneficiary_3" => $passg_details[3],
			"beneficiary_4" => $passg_details[4],
			"beneficiary_5" => $passg_details[5],
			"contact_phone" => $request->contact_phone,
			"contact_email" => $request->contact_email,
			"emergency_contact_fullname" => $request->emergency_contact_fullname,
			"emergency_contact_phone" => $request->emergency_contact_phone,
			"billing_fiscal_condition" => $request->billing_fiscal_condition,
			"billing_fullname" => $request->billing_fullname,
			"billing_tax_number" => $request->billing_tax_number,
			"billing_address_street" => $request->billing_address_street,
			"billing_address_number" => $request->billing_address_number,
			"billing_address_appt" => $request->billing_address_appt,
			"billing_address_city" => $request->billing_address_city,
			"billing_address_state" => $request->billing_address_state,
			"billing_address_zip" => $request->billing_address_zip,
			"billing_address_country" => 32, 
			"final_price" => $quotationProduct->price
		]);
		$contract->changeStatus(Contract::STATUS_PAYMENT_PENDING);


		if($quotationProduct->price_currency_code == "ARS")
		{
			$customRequest = MercadoPagoRequest::create(
				$contract->id,
				$contract->number,
				$quotationProduct->id,
				$quotationProduct->product_name,
				1,
				$quotationProduct->price,
				$contract->contact_email,
				$contract->billing_fullname,
				""
			);

		}
		else if($quotationProduct->price_currency_code == "USD")
		{
			$customRequest = PaypalRequest::create(
				$contract->id,
				$contract->number,
				$quotationProduct->product_name,
				1,
				$quotationProduct->price
			);
		}
		else
			return "No payment methods available";


		if($customRequest == false) {
			$contract->delete();
			return view("front.contract.error")->with("error", "payment-request-error");
		}

		$contract->active_payment_req_id = $customRequest->parentRequest->id;
		$contract->save();



		$quotation->contract_id = $contract->id;
		$quotation->save();


		return redirect()->away($customRequest->parentRequest->payment_url);

	}



	/**
	 * Muestra página de información de contratación.
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function viewContractDetails(Request $request)
	{

		if($request->contract_number != null)
		{

			if($contract = Contract::findByNumber($request->contract_number))
			{


				return view("front.contract.details")->with([
					"contract_found" => true,
					"contract" => $contract,
					"quotation" => $contract->quotation,
					"product" => $contract->product,
					"product_coverage" => json_decode($contract->product->coverage_details_json, true),
					"paymentReq" => $contract->active_payment_request
				]);

			}
			else
				return view("front.contract.details")->with(["contract_found" => false]);

		}
		else
			return redirect("");

		
	}




}
