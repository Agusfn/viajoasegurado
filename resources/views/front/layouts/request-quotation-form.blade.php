{{ Form::open( array("url" => uri_localed("quotation/create"), "method" => "post", "id" => "quote-form") ) }}
    <h2 style="margin-bottom: 25px">{{ __("front/shared/quotation_form.find_insurances") }}</h2>
    @include('front.layouts.errors')
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group form-group-lg form-group-icon-left">
                <i class="fa fa-map-marker input-icon" style="color: #84c1e0"></i>
                <label>{{ __("front/shared/quotation_form.country_from") }}</label>
                <input type="text" class="typeahead form-control" id="country-from-input" placeholder="{{ __('Country') }}" data-provide="typeahead" autocomplete="off" />
                <input type="hidden" name="country_code_from">
                <label class="form-error" id="country-from-error">{{ __("front/shared/quotation_form.invalid_origin") }}</label>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-group-lg form-group-icon-left">
                <i class="fa fa-map-marker input-icon" style="color: #84c1e0"></i>
                <label>{{ __("front/shared/quotation_form.region_to") }}</label>
                <select class="form-control" name="region_code_to">
                    <option>{{ __("Select") }}</option>
                    @foreach($regions_to as $region)
                    <option value="{{ $region['id'] }}">{{ $region["name"] }}</option>
                    @endforeach
                </select>
                <label class="form-error" id="region-to-error">{{ __("front/shared/quotation_form.invalid_destination") }}</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group form-group-lg form-group-icon-left">
                <i class="fa fa-calendar input-icon input-icon-highlight" style="color: #84c1e0"></i>
                <label>{{ __("front/shared/quotation_form.date_from") }}</label>
                <input class="form-control" name="date_start" type="text" data-date-format="dd/mm/yyyy" data-date-language="{{ \App::getLocale() }}" />
                <label class="form-error" id="date-start-error">{{ __("front/shared/quotation_form.invalid_date_from") }}</label>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group form-group-lg form-group-icon-left">
                <i class="fa fa-calendar input-icon input-icon-highlight" style="color: #84c1e0"></i>
                <label>{{ __("front/shared/quotation_form.date_to") }}</label>
                <input class="form-control" name="date_end" type="text" data-date-format="dd/mm/yyyy" data-date-language="{{ \App::getLocale() }}" />
                <label class="form-error" id="date-end-error">{{ __("front/shared/quotation_form.invalid_date_to") }}</label>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-6">
            <div class="form-group" style="padding-top: 28px; margin-bottom: 42px">
                <label style="display: inline">
                    <img src="{{ asset('front/img/icons/pregnant.png') }}" style="width: 30px; margin-left: 9px" />
                    &nbsp;{{ __("front/shared/quotation_form.travel_pregnant") }}
                    &nbsp;&nbsp;&nbsp;<input type="checkbox" class="icheckbox" name="travel_pregnant">
                </label>
                <i class="fa fa-info-circle" style="color: #e81984;margin-left: 17px; font-size: 18px;display: inline" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="{{ __('front/shared/quotation_form.pregnant_message') }}" ></i>
            </div>
        </div>

        <div class="col-sm-6">
                <input type="hidden" name="passenger_ammount">
                <div class="form-group form-group-lg" id="traveler-ages-form-group">
                    <label>{{ __("front/shared/quotation_form.ages") }}</label>
                    <input type="text" class="form-control" name="age1" id="age1-input" maxlength="2">&nbsp;
                    <input type="text" class="form-control" name="age2" id="age2-input" maxlength="2">&nbsp;
                    <input type="text" class="form-control" name="age3" id="age3-input" maxlength="2">&nbsp;
                    <input type="text" class="form-control" name="age4" id="age4-input" maxlength="2">&nbsp;
                    <input type="text" class="form-control" name="age5" id="age5-input" maxlength="2">&nbsp;
                    <label class="form-error" id="ages-error">{{ __("front/shared/quotation_form.invalid_ages") }}</label>
                </div>

                <div class="row" id="pregnant-inputs" style="margin-bottom: 20px">
                    <div class="col-xs-4">
                        <div class="form-group form-group-lg" style="margin-bottom: 5px">
                            <label>Tu edad</label>
                            <input type="text" name="pregnant_age" class="form-control" maxlength="2" style="width: 65px" disabled="">
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <div class="form-group form-group-lg" style="margin-bottom: 5px">
                            <label>{{ __("front/shared/quotation_form.gestation_weeks") }}</label>
                            <input type="text" name="gestation_weeks" class="form-control short-input" maxlength="2" style="width: 65px" disabled="">
                        </div>
                    </div>
                    <label class="form-error" id="pregnant-error">{{ __("front/shared/quotation_form.invalid_pregnant_age_or_weeks") }}</label>
                </div>



        </div>

    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group form-group-lg form-group-icon-left">
                <i class="fa fa-envelope input-icon input-icon-highlight" style="color: #84c1e0"></i>
                <label>{{ __("front/shared/quotation_form.email") }}</label>
                <input type="text" class="form-control" name="email">
                <label class="form-error" id="email-error">{{ __("front/shared/quotation_form.invalid_email") }}</label>
            </div>
        </div>
        <div class="col-sm-6" style="text-align: right;">
            <button type="button" class="btn btn-primary btn-lg" id="submit-quote-btn" style="margin-top: 28px">{{ __("front/shared/quotation_form.quote") }}</button>
        </div>
            

    </div>


    
{{ Form::close() }}