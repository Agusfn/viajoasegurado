<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \App\Quotation;

class CreateContract extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            
            /* Campos necesarios */

            "quotation_code" => "required|max:100",
            "quotationproduct_atvid" => "required|max:100",
            "contact_phone" => "required|regex:/^[0-9\(\) \-\+\/]{1,30}$/",
            "contact_email" => "required|email|max:100",
            "emergency_contact_fullname" => "required|max:100",
            "emergency_contact_phone" => "required|regex:/^[0-9\(\) \-\+\/]{1,30}$/",

            /* Campos opcionales */

            // Pasajeros
            "passg1_name" => "nullable|max:50",
            "passg1_surname" => "nullable|max:50",
            "passg1_document" => "nullable|max:50",
            "passg1_birthdate" => "nullable|date_format:d/m/Y",

            "passg2_name" => "nullable|max:50",
            "passg2_surname" => "nullable|max:50",
            "passg2_document" => "nullable|max:50",
            "passg2_birthdate" => "nullable|date_format:d/m/Y",

            "passg3_name" => "nullable|max:50",
            "passg3_surname" => "nullable|max:50",
            "passg3_document" => "nullable|max:50",
            "passg3_birthdate" => "nullable|date_format:d/m/Y",

            "passg4_name" => "nullable|max:50",
            "passg4_surname" => "nullable|max:50",
            "passg4_document" => "nullable|max:50",
            "passg4_birthdate" => "nullable|date_format:d/m/Y",

            "passg5_name" => "nullable|max:50",
            "passg5_surname" => "nullable|max:50",
            "passg5_document" => "nullable|max:50",
            "passg5_birthdate" => "nullable|date_format:d/m/Y",

            // Datos de facturacion
            "billing_fiscal_condition" => "nullable|max:50|in:consumidor-final,monotributo,resp-inscripto,iva-exento",
            "billing_fullname" => "nullable|max:100",
            "billing_tax_number" => "nullable|max:15",
            "billing_address_street" => "nullable|max:50",
            "billing_address_number" => "nullable|max:8",
            "billing_address_appt" => "nullable|max:10",
            "billing_address_city" => "nullable|max:50",
            "billing_address_zip" => "nullable|max:10",
            "billing_address_state" => "nullable|max:50",
            "billing_address_country" => "nullable|max:100"


        ];
    }
}
