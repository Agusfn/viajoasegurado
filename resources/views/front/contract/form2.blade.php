@extends('front.layouts.main2')        



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
                Se encontraron errores en el formulario:
                <ul>
                    <li id="passenger-name-error">Ingresa el nombre y apellido de todos los pasajeros.</li>
                    <li id="passenger-document-error">Ingresa el número de documento o de identificación de todos los pasajeros.</li>
                    <li id="passenger-birthdate-error">Ingresa la fecha de nacimiento válida de todos los pasajeros de acuerdo a sus edades.</li>
                    <li id="billing-name-error">Ingresa el nombre y apellido o razón social de facturación.</li>
                    <li id="billing-tax-no-error">Ingresa el DNI o CUIT correctamente (cuit con guiones).</li>
                    <li id="billing-address-error">Ingresa la dirección de facturación.</li>
                    <li id="contact-phone-error">Ingresa números de teléfono de contacto válidos (sin caracteres especiales).</li>
                    <li id="contact-email-error">Ingresa un e-mail de contacto válido.</li>
                    <li id="contact-emerg-name-error">Ingresa el nombre del contacto de emergencia.</li>
                </ul>
            </div>

            <div class="row row-wrap">
                <div class="col-md-8">

                    {{ Form::open(["url" => "contract", "method" => "post", "id" => "contract-form"]) }}
                        <input type="hidden" name="quotation_code" value="{{ $quotation->url_code }}">
                        <input type="hidden" name="quotationproduct_atvid" value="{{ $product->product_atv_id }}">

                        <h3>Pasajeros</h3>

                        <ul class="list booking-item-passengers">
                            @php($ages = \App\Quotation::agesCsvToArray($quotation->passenger_ages, 0)) 
                            @for ($i=1; $i<=$quotation->passenger_ammount; $i++)
                            <li>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input class="form-control" type="text" name="passg{{$i}}_name" maxlength="50" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Apellido</label>
                                            <input class="form-control" type="text" name="passg{{$i}}_surname" maxlength="50" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Documento</label>
                                            <input class="form-control" type="text" name="passg{{$i}}_document" maxlength="50" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Fecha de nacimiento</label>
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

                                <h4>Datos de facturación</h4>

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

                                <h4>Datos de contacto</h4>

                                <div class="row ">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input class="form-control" type="text" name="contact_phone" maxlength="30"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input class="form-control" type="text" name="contact_email" maxlength="100" />
                                        </div>
                                    </div>
                                </div>
                                <h5>Contacto emergencia</h5>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nombre completo</label>
                                            <input class="form-control" type="text" name="emergency_contact_fullname" maxlength="100" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Teléfono</label>
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
                                <img class="pp-img" src="{{ asset('front/img/mercadopago-large.png') }}" alt="Image Alternative text" title="Image Title" />
                                <p>Serás redirigido a la página de MercadoPago para completar el pago de forma segura.</p>
                                <a class="btn btn-primary" id="submit-form-btn">Pagar con MercadoPago</a>
                            @elseif ($product->price_currency_code == "USD")
                                <img class="pp-img" src="{{ asset('front/img/paypal.png') }}" alt="Image Alternative text" title="Image Title" />
                                <p>Serás redirigido a la página de PayPal para completar el pago de forma segura.</p>
                                <a class="btn btn-primary" id="submit-form-btn">Pagar con PayPal</a>
                            @endif

                        </div>
                        <div class="col-md-6"></div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="booking-item-payment">
                        <header class="clearfix">
                            <h5 class="mb0">Detalles</h5>
                        </header>
                        <ul class="booking-item-payment-details">
                            <li>
                                <h5>Detalles del viaje</h5>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <small><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;ORIGEN</small>
                                        <p>{{ __($quotation->country_from->name_english) }}</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <small><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;DESTINO</small>
                                        <p>{{ \App\Library\AseguratuViaje\ATV::getRegionName($quotation->destination_region_code) }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <small><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;DESDE</small>
                                        <p>{{ \App\Library\Dates::translate($quotation->date_from) }}</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <small><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;HASTA</small>
                                        <p>{{ \App\Library\Dates::translate($quotation->date_to) }}
                                        ({{ (new DateTime($quotation->date_to))->diff(new DateTime($quotation->date_from))->format("%a") }} días)</p>
                                    </div>
                                </div>
                                <div>
                                    <small>PASAJEROS:</small> {{ $quotation->passenger_ammount }}
                                    <span style="font-size: 12px">({{ $quotation->ageEnum() }})</span>
                                </div>                         
                            </li>
                            <li>
                                <h5>Detalles del seguro</h5>
                                <small>PROVEEDOR:</small>
                                <p>{{ $product->provider_name }}</p>
                                <small>PRODUCTO:</small>
                                <p>{{ $product->product_name }}</p>
                                <small>COBERTURA:</small>
                                <ul class="list-unstyled coverage-details-list">
                                    @if (sizeof($product_coverage) > 10)
                                        @for ($i=0; $i<10; $i++)
                                            <li>{{ $product_coverage[$i]["description"] }}: <strong>{{ $product_coverage[$i]["ammount"] }}</strong></li>
                                        @endfor
                                        <a href="javascript:void(0);" onclick="$(this).hide();$('#coverage-collapse').show();">Mostrar todo</a>
                                        <div id="coverage-collapse" style="display: none">
                                        @for ($i=10; $i<sizeof($product_coverage); $i++)
                                            <li>{{ $product_coverage[$i]["description"] }}: <strong>{{ $product_coverage[$i]["ammount"] }}</strong></li>
                                        @endfor
                                        </div>
                                    @else
                                        @foreach ($product_coverage as $coverage)
                                        <li>{{ $coverage["description"] }}: <strong>{{ $coverage["ammount"] }}</strong></li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="gap-small"></div>
                                <a href="{{ $product->terms_url }}" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;Términos y condiciones del seguro</a>
                            </li>
                        </ul>
                        <p class="booking-item-payment-total">Total: <span>{{ $product->price." ".$product->price_currency_code }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
        </div>
        @else
        <h4 style="text-align: center;">La cotización no es válida o expiró.
        <br/>
        <small><a href="{{ URL::to('') }}">Realiza una nueva consulta</a></small>
        </h4>
        @endif
        
@endsection


@section('custom-js')
@if($validContract)
<script>
var passg_ammt = {{ $quotation->passenger_ammount }};
</script>
<script src="{{ asset('front/js/contract-form-pg.js') }}">
@endif
@endsection