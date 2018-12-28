<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Contract;
use \App\Quotation;
use \App\QuotationProduct;
use \App\PaymentMethod;

use \App\MercadoPagoRequest;
use \App\PaypalRequest;

use \App\Library\AseguratuViaje\ATV;



class ContractController extends Controller
{
    

	public function showContractForm(Request $request)
	{
		$parameters = [
			"validContract" => false
		];
		
		if($quotation = Quotation::findByUrlCode($request->quot_url_code))
		{
			
			if(!$quotation->expired() && $quotation->contract_id == null)
			{

				$quotationProduct = $quotation->getProductByAtvId($request->quotproduct_atvid);

				if($quotationProduct != null)
				{

					if($quotationProduct->coverage_details_json == null)
						$quotationProduct->fetchAndSaveCoverageDetails(ATV::getLocale($quotation->lang));


					return view("front.contract.form2")->with([
						"validContract" => true,
						"quotation" => $quotation, 
						"product" => $quotationProduct, 
						"product_coverage" => json_decode($quotationProduct->coverage_details_json, true)
					]);
				}

			}

		}


		return view("front.contract.form2")->with($parameters);


	}




	public function processContractForm(Request $request)
	{

		dd($request);
		
		$quotation = Quotation::findByUrlCode($request->quotation_code);

		if($quotation == null)
			return "error";

		if($quotation->expired() || $quotation->contract_id != null)
			return "expiro";

		$quotationProduct = $quotation->getProductByAtvId($request->quotationproduct_atvid);

		if($quotationProduct == null)
			return "error";



		/* Validar datos!! */

		$passg_details = [null, null, null, null, null];
		for($i=1; $i<=$quotation->passenger_ammount; $i++) {
			$passg_details[$i] = $request->{"passg".$i."_name"}.",".$request->{"passg".$i."_surname"}.",".$request->{"passg".$i."_document"}.",".$request->{"passg".$i."_birthdate"};
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
			"emergency_contact_fullname" => $request->emerg_contact_name,
			"emergency_contact_phone" => $request->emerg_contact_phone,
			"billing_fiscal_condition" => $request->billing_fiscal_condition,
			"billing_fullname" => $request->billing_fullname,
			"billing_tax_number" => $request->billing_tax_number,
			"billing_address_street" => $request->billing_address_street,
			"billing_address_number" => $request->billing_address_number,
			"billing_address_appt" => $request->billing_address_appt,
			"billing_address_city" => $request->billing_address_city,
			"billing_address_state" => $request->billing_address_state,
			"billing_address_zip" => $request->billing_address_zip,
			"billing_address_country" => $request->billing_address_country,
			"final_price" => $quotationProduct->price
		]);
		$contract->changeStatus(Contract::STATUS_PAYMENT_PENDING);


		if($quotationProduct->price_currency_code == "ARS")
		{
			$customRequest = MercadoPagoRequest::create(
				$contract->id,
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
				$quotationProduct->product_name,
				1,
				$quotationProduct->price
			);
		}
		else
			return "Error no hay medios de pagos disponibles";


		if($customRequest == false) {
			$contract->delete();
			return "Error generando solicitud de pago";
		}


		$quotation->contract_id = $contract->id;
		$quotation->save();

		$contract->active_payment_req_id = $customRequest->parentRequest->id;
		$contract->save();


		return redirect()->away($customRequest->parentRequest->payment_url);

	}




	public function viewContractDetails(Request $request)
	{

		if($request->contract_number != null)
		{

			if($contract = Contract::findByNumber($request->contract_number))
			{


				return view("front.contract.details")->with([
					"contract_found" => true,
					"contract" => $contract,
					"product" => $contract->product,
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
