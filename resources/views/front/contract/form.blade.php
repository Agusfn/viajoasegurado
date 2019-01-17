@extends('front.layouts.main')        

@section('title', __('front/contract_form.title'))


@section('meta-tags')
    <meta name="robots" content="noindex, nofollow"> 
@endsection


@section('content')
    
        <div class="gap"></div>

        @if ($validContract)
        <div class="container">



            @if($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif



            <div class="alert alert-danger alert-dismissible" role="alert" id="error-list" style="display: none">
                <button type="button" class="close" aria-label="Close" onclick="$(this).parent().hide();"><span aria-hidden="true">&times;</span></button>
                {{ __('front/contract_form.errors_found') }}:
                <ul>
                    <li id="passenger-name-error">{{ __('front/contract_form.error_passenger_names') }}</li>
                    <li id="passenger-document-error">{{ __('front/contract_form.error_passenger_documents') }}</li>
                    <li id="passenger-birthdate-error">{{ __('front/contract_form.error_passenger_birthdates') }}</li>
                    <li id="billing-name-error">{{ __('front/contract_form.error_billing_name') }}</li>
                    <li id="billing-tax-no-error">{{ __('front/contract_form.error_billing_tax_no') }}</li>
                    <li id="billing-address-error">{{ __('front/contract_form.error_billing_address') }}</li>
                    <li id="contact-phone-error">{{ __('front/contract_form.error_contact_phones') }}</li>
                    <li id="contact-email-error">{{ __('front/contract_form.error_contact_email') }}</li>
                    <li id="contact-emerg-name-error">{{ __('front/contract_form.error_contact_emerg_name') }}</li>
                </ul>
            </div>

            <div class="row row-wrap">
                <div class="col-md-8">

                    {{ Form::open(["url" => "contract", "method" => "post", "id" => "contract-form"]) }}
                        <input type="hidden" name="quotation_code" value="{{ $quotation->url_code }}">
                        <input type="hidden" name="quotationproduct_atvid" value="{{ $product->product_atv_id }}">

                        <h3>{{ __('front/contract_form.travelers') }}</h3>

                        <ul class="list booking-item-passengers">
                            @php($ages = \App\Quotation::agesCsvToArray($quotation->passenger_ages, 0)) 
                            @for ($i=1; $i<=$quotation->passenger_ammount; $i++)
                            <li>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>{{ __('front/contract_form.name') }}</label>
                                            <input class="form-control" type="text" name="passg{{$i}}_name" maxlength="50" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>{{ __('front/contract_form.surname') }}</label>
                                            <input class="form-control" type="text" name="passg{{$i}}_surname" maxlength="50" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>{{ __('front/contract_form.document') }}</label>
                                            <input class="form-control" type="text" name="passg{{$i}}_document" maxlength="50" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>{{ __('front/contract_form.birthdate') }}</label>
                                            <input class="date-pick-years form-control" type="text" name="passg{{$i}}_birthdate" data-age="{{ $ages[$i-1] }}" maxlength="10" data-date-format="dd/mm/yyyy" data-date-language="{{ \App::getLocale() }}" />
                                        </div>
                                    </div>
                                </div>
                            </li>                       
                            @endfor


                            
                        </ul>
                        <div class="gap gap-small"></div>

                        <div class="row">

                            @if ($quotation->origin_country_code == 32)
                            <div class="col-md-6" id="billing-information">

                                <h4>{{ __('front/contract_form.billing_data') }}</h4>

                                <div class="form-group">
                                    <label>Condición fiscal</label>
                                    <select class="form-control" name="billing_fiscal_condition">
                                        <option value="consumidor-final">Consumidor final</option>
                                        <option value="monotributo">Monotributo</option>
                                        <option value="resp-inscripto">Responsable inscripto</option>
                                        <option value="iva-exento">IVA exento</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label id="billing-fullname-label">Nombre y apellido</label>
                                            <input class="form-control" type="text" name="billing_fullname" maxlength="100" />
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label id="billing-tax-no-label">DNI</label>
                                            <input class="form-control" type="text" name="billing_tax_number" maxlength="15" />
                                        </div>
                                    </div>                            
                                </div>


                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Calle</label>
                                            <input class="form-control" type="text" name="billing_address_street" maxlength="50" />
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label>Altura</label>
                                            <input class="form-control" type="text" name="billing_address_number" maxlength="8" />
                                        </div>
                                    </div> 
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label>Piso/depto</label>
                                            <input class="form-control" type="text" name="billing_address_appt" maxlength="10" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-8">
                                        <div class="form-group">
                                            <label>Localidad</label>
                                            <input class="form-control" type="text" name="billing_address_city" maxlength="50" />
                                        </div>                          
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-group">
                                            <label>Cód. postal</label>
                                            <input class="form-control" type="text" name="billing_address_zip" maxlength="10" />
                                        </div>
                                    </div>                            
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Provincia</label>
                                            <input class="form-control" type="text" name="billing_address_state" maxlength="50" />
                                        </div>                               
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>País</label>
                                            <input class="form-control" type="text" name="billing_address_country" value="Argentina" disabled="" />
                                        </div>
                                    </div>                            
                                </div>

                            </div>
                            <div class="col-md-6">
                            @else
                            <div class="col-md-12">
                            @endif

                                <h4>{{ __('front/contract_form.contact_info') }}</h4>

                                <div class="row ">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>{{ __('front/contract_form.phone') }}</label>
                                            <input class="form-control" type="text" name="contact_phone" maxlength="30"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>{{ __('front/contract_form.email') }}</label>
                                            <input class="form-control" type="text" name="contact_email" maxlength="100" />
                                        </div>
                                    </div>
                                </div>
                                <h5>{{ __('front/contract_form.emergency_contact') }}</h5>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>{{ __('front/contract_form.full_name') }}</label>
                                            <input class="form-control" type="text" name="emergency_contact_fullname" maxlength="100" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>{{ __('front/contract_form.phone') }}</label>
                                            <input class="form-control" type="text" name="emergency_contact_phone" maxlength="30" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    {{ Form::close() }}

                    <div class="row" style="margin-top: 30px">
                        <div class="col-md-6">

                            @if($product->price_currency_code == "ARS")
                                <img class="pp-img" src="{{ asset('front/img/mercadopago-large.png') }}" alt="MercadoPago" />
                                <p>{{ __('front/contract_form.mercadopago_redirect') }}</p>
                                <a class="btn btn-primary" id="submit-form-btn">{{ __('front/contract_form.pay_with_mercadopago') }}</a>
                            @elseif ($product->price_currency_code == "USD")
                                <img class="pp-img" src="{{ asset('front/img/paypal.png') }}" alt="PayPal" />
                                <p>{{ __('front/contract_form.paypal_redirect') }}</p>
                                <a class="btn btn-primary" id="submit-form-btn">{{ __('front/contract_form.pay_with_paypal') }}</a>
                            @endif

                        </div>
                        <div class="col-md-6"></div>
                    </div>

                </div>
                <div class="col-md-4">
                    @include('front.layouts.contract-summary')
                </div>
            </div>
            <div class="gap"></div>
        </div>
        @else
        <h4 style="text-align: center;margin-top: 100px;">{{ __('front/contract_form.quotation_invalid') }}
        <br/>
        <small><a href="{{ URL::to('') }}">{{ __('front/contract_form.request_new_quote') }}</a></small>
        </h4>
        @endif
        
@endsection


@section('custom-js')

@if($validContract)
<script>
var passg_ammt = {{ $quotation->passenger_ammount }};
</script>
<script src="{{ asset('front/js/contract-form-pg.js') }}"></script>
@endif

@endsection