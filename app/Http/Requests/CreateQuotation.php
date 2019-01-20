<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateQuotation extends FormRequest
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

        $countries_from_ids = [];
        foreach(config("custom.insurances.countries_from") as $country_from) {
            $countries_from_ids[] = $country_from["id"];
        }

        $regions_to_ids = [];
        foreach(config("custom.insurances.regions_to") as $region_to) {
            $regions_to_ids[] = $region_to["id"];
        }


        return [
            "country_code_from" => [
                "required",
                "numeric",
                Rule::in($countries_from_ids)
            ],
            "region_code_to" => [
                "required",
                "numeric",
                Rule::in($regions_to_ids)
            ],
            "date_start" => "required|date_format:d/m/Y|after:today",
            "date_end" => "required|date_format:d/m/Y|after:date_start",
            "travel_pregnant" => "in:on",
            "passenger_ammount" => "required|integer|in:1,2,3,4,5",
            "age1" => "nullable|integer|min:1|max:99",
            "age2" => "nullable|integer|min:1|max:99",
            "age3" => "nullable|integer|min:1|max:99",
            "age4" => "nullable|integer|min:1|max:99",
            "age5" => "nullable|integer|min:1|max:99",
            "pregnant_age" => "required_if:travel_pregnant,=,on|nullable|integer|min:1|max:99",
            "gestation_weeks" => "required_if:travel_pregnant,=,on|nullable|integer|min:1|max:36",
            "email" => "required|email|max:100",
        ];
    }
}
