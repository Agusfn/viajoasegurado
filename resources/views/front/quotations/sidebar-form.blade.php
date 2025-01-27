{{ Form::open( array("url" => uri_localed("quotation/create"), "method" => "post", "id" => "quote-form") ) }}
    
    @include('front.layouts.errors')

        <div class="form-group form-group-lg form-group-icon-left">
            <i class="fa fa-map-marker input-icon" style="color: #84c1e0"></i>
            <label>{{ __("front/shared/quotation_form.country_from") }}</label>
            <input type="text" class="typeahead form-control" id="country-from-input" placeholder="{{ __('Country') }}" data-provide="typeahead" autocomplete="off" @if($quotation) value="{{ __($quotation->country_from->name_english) }}" @endif autocomplete="off" />
            <input type="hidden" name="country_code_from" @if($quotation) value="{{ __($quotation->origin_country_code) }}" @endif autocomplete="off">
            <label class="form-error" id="country-from-error">{{ __("front/shared/quotation_form.invalid_origin") }}</label>
        </div>


        <div class="form-group form-group-lg form-group-icon-left">
            <i class="fa fa-map-marker input-icon" style="color: #84c1e0"></i>
            <label>{{ __("front/shared/quotation_form.region_to") }}</label>
            <select class="form-control" name="region_code_to" autocomplete="off">
                <option>{{ __("Select") }}</option>
                @foreach($regions_to as $region)
                <option value="{{ $region['id'] }}" @if($quotation && $region['id'] == $quotation->destination_region_code) selected @endif>{{ $region["name"] }}</option>
                @endforeach
            </select>
            <label class="form-error" id="region-to-error">{{ __("front/shared/quotation_form.invalid_destination") }}</label>
        </div>


        <div class="form-group form-group-lg form-group-icon-left">
            <i class="fa fa-calendar input-icon input-icon-highlight" style="color: #84c1e0"></i>
            <label>{{ __("front/shared/quotation_form.date_from") }}</label>
            <input class="form-control" name="date_start" type="text" data-date-format="dd/mm/yyyy" data-date-language="{{ \App::getLocale() }}" autocomplete="off" @if($quotation) value="{{ $quotation->date_from->format('d/m/Y') }}" @endif />
            <label class="form-error" id="date-start-error">{{ __("front/shared/quotation_form.invalid_date_from") }}</label>
        </div>

        <div class="form-group form-group-lg form-group-icon-left">
            <i class="fa fa-calendar input-icon input-icon-highlight" style="color: #84c1e0"></i>
            <label>{{ __("front/shared/quotation_form.date_to") }}</label>
            <input class="form-control" name="date_end" type="text" data-date-format="dd/mm/yyyy" data-date-language="{{ \App::getLocale() }}" autocomplete="off" @if($quotation) value="{{ $quotation->date_to->format('d/m/Y') }}" @endif />
            <label class="form-error" id="date-end-error">{{ __("front/shared/quotation_form.invalid_date_to") }}</label>
        </div>


        <div class="form-group" style="padding-top: 28px; margin-bottom: 34px">
            <label style="display: inline">
                <img src="{{ asset('front/img/icons/pregnant.png') }}" style="width: 30px; margin-left: 9px" />
                {{ __("front/shared/quotation_form.travel_pregnant") }}
                &nbsp;&nbsp;<input type="checkbox" class="icheckbox" name="travel_pregnant">
            </label>
            <i class="fa fa-info-circle" style="color: #e81984;margin-left: 8px; font-size: 18px;display: inline" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('front/shared/quotation_form.pregnant_message') }}" ></i>
        </div>

        <input type="hidden" name="passenger_ammount">

        <div class="form-group form-group-lg" id="traveler-ages-form-group">
            <label>{{ __("front/shared/quotation_form.ages") }}</label>
            @if($quotation)
            @php($ages = $quotation->agesArray())
            @endif
            <input type="text" class="form-control" name="age1" id="age1-input" maxlength="2" @if($quotation && $ages[0] != 0) value="{{ $ages[0] }}" @endif>
            <input type="text" class="form-control" name="age2" id="age2-input" maxlength="2" @if($quotation && $ages[1] != 0) value="{{ $ages[1] }}" @endif>
            <input type="text" class="form-control" name="age3" id="age3-input" maxlength="2" @if($quotation && $ages[2] != 0) value="{{ $ages[2] }}" @endif>
            <input type="text" class="form-control" name="age4" id="age4-input" maxlength="2" @if($quotation && $ages[3] != 0) value="{{ $ages[3] }}" @endif>
            <input type="text" class="form-control" name="age5" id="age5-input" maxlength="2" @if($quotation && $ages[4] != 0) value="{{ $ages[4] }}" @endif>
            <label class="form-error" id="ages-error">{{ __("front/shared/quotation_form.invalid_ages") }}</label>
        </div>

        <div class="row" id="pregnant-inputs" style="margin-bottom: 20px">
            <div class="col-xs-4">
                <div class="form-group form-group-lg" style="margin-bottom: 5px">
                    <label>{{ __('front/shared/quotation_form.your_age') }}</label>
                    <input type="text" name="pregnant_age" class="form-control" maxlength="2" style="width: 65px" disabled="" @if($quotation && $quotation->travelPregnant()) value="{{ $quotation->agesArray()[0] }}" @endif>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="form-group form-group-lg" style="margin-bottom: 5px">
                    <label>{{ __("front/shared/quotation_form.gestation_weeks") }}</label>
                    <input type="text" name="gestation_weeks" class="form-control short-input" maxlength="2" style="width: 65px" disabled="" @if($quotation && $quotation->travelPregnant()) value="{{ $quotation->gestation_weeks }}" @endif>
                </div>
            </div>
            <label class="form-error" id="pregnant-error">{{ __("front/shared/quotation_form.invalid_pregnant_age_or_weeks") }}</label>
        </div>

        <div class="form-group form-group-lg form-group-icon-left">
            <i class="fa fa-envelope input-icon input-icon-highlight" style="color: #84c1e0"></i>
            <label>{{ __("front/shared/quotation_form.email") }}</label>
            <input type="text" class="form-control" name="email" @if($quotation) value="{{ $quotation->customer_email }}" @endif>
            <label class="form-error" id="email-error">{{ __("front/shared/quotation_form.invalid_email") }}</label>
        </div>
        <button type="button" class="btn btn-primary btn-lg" id="submit-quote-btn" style="margin-top: 28px; width: 100%">{{ __("front/shared/quotation_form.quote") }}</button>



    
{{ Form::close() }}