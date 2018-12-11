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


		if($quotation = Quotation::findByUrlCode($request->quot_url_code))
		{
			
			if(!$quotation->expired() && $quotation->contract_id == null)
			{

				$quotationProduct = $quotation->getProductByAtvId($request->quotproduct_atvid);

				if($quotationProduct != null)
				{

					if($quotationProduct->coverage_details_json == null)
						$quotationProduct->fetchAndSaveCoverageDetails(ATV::getLocale($quotation->lang));


					return view("frontoffice.contract.form")->with([
						"quotation" => $quotation, 
						"quotation_product" => $quotationProduct, 
						"product_coverage" => json_decode($quotationProduct->coverage_details_json, true)
					]);
				}

			}

		}

		return view("frontoffice.contract.notfound");


	}




	public function processContractForm(Request $request)
	{

		$quotation = Quotation::findByUrlCode($request->quotation_code);

		if($quotation == null)
			return "error";

		if($quotation->expired() || $quotation->contract_id != null)
			return "expiro";

		$quotationProduct = $quotation->getProductByAtvId($request->quotationproduct_atvid);

		if($quotationProduct == null)
			return "error";



		/* Validar datos!! */

		
		$contract = Contract::create([
			"number" => Contract::randomNumber(),
			"status_code" => "",
			"quotation_id" => $quotation->id,
			"quotation_product_id" => $quotationProduct->id,
			"active_payment_req_id" => null,
			"subscriber_name" => $request->nombre_titular,
			"subscriber_surname" => $request->apellido_titular,
			"subscriber_email" => $request->email_titular,
			"subscriber_address" => "",
			"subscriber_city" => "",
			"subscriber_state" => "",
			"subscriber_zip" => "",
			"subscriber_country" => "",
			"subscriber_phone" => "",
			"emergency_contact_fullname" => "",
			"emergency_contact_phone" => "",
			"billing_fullname" => $request->nombre_titular,
			"billing_address" => $request->apellido_titular,
			"billing_id_number" => "99999999",
			"beneficiary_1" => $request->nombre_titular.",".$request->apellido_titular.",99999999,1996-05-20",
			"beneficiary_2" => "",
			"beneficiary_3" => "",
			"beneficiary_4" => "",
			"beneficiary_5" => "",
			"final_price" => $quotationProduct->cost
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
				$contract->subscriber_email,
				$contract->subscriber_name,
				$contract->subscriber_surname
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
			return "Error generando solicitud de pago"; // cambiar
		}

		$paymentReq = $customRequest->parentRequest();
		$paymentRedirectUrl = $paymentReq->payment_method == "paypal" ? $customRequest->approval_url : $customRequest->preference_url;



		$quotation->contract_id = $contract->id;
		$quotation->save();

		$contract->active_payment_req_id = $paymentReq->id;
		$contract->save();


		return redirect()->away($paymentRedirectUrl);

	}




}
