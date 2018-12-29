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
        $quotation = Quotation::findByUrlCode(234);

        return false;

        if(!$quotation)
            return ["" => ""];

        dd($this->input("quotation_code"));

        return [
            "quotation_code" => "required|unique:posts|max:255",
            "quotationproduct_atvid" => "required",
            "contact_phone" => "",
            "contact_email" => "",
            "emergency_contact_fullname" => "",
            "emergency_contact_phone" => ""
        ];
    }
}
