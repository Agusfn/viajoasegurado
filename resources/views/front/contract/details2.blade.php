@extends('front.layouts.main2')        



@section('content')
    
        <div class="gap"></div>

        @if ($contract_found == true)

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">


                    @if ($paymentReq->status == \App\PaymentRequest::STATUS_UNPAID)
                        
                        <i class="fa fa-clock-o round box-icon-large box-icon-center box-icon-gray mb30"></i>  
                        <h2 class="text-center">Pendiente de pago</h2>
                        <h5 class="text-center mb30">El pago está pendiente, completalo desde <a href="{{ $paymentReq->payment_url }}">aquí</a>.</h5>

                    @elseif ($paymentReq->status == \App\PaymentRequest::STATUS_PROCESSING)
                        
                        <i class="fa fa-clock-o round box-icon-large box-icon-center box-icon-gray mb30"></i>  
                        <h2 class="text-center">Procesando</h2>
                        <h5 class="text-center mb30">El pago se está procesando, te notificaremos por e-mail cuando se complete el pago. <br/>También puedes volver a visitar esta página para ver el estado del mismo.</h5>

                    @elseif ($paymentReq->status == \App\PaymentRequest::STATUS_APPROVED)
                        
                        <i class="fa fa-check round box-icon-large box-icon-center box-icon-success mb30"></i>  
                        <h2 class="text-center">Tu pago se ha completado</h2>
                        
                        @if ($contract->current_status_id == \App\Contract::STATUS_PROCESSING)
                            <h5 class="text-center mb30"><i class="fa fa-clock-o" aria-hidden="true"></i> El pedido se está procesando.<br/> En las próximas 1-3 horas recibirás por e-mail toda la información necesaria de póliza.</h5>
                        @elseif ($contract->current_status_id == \App\Contract::STATUS_COMPLETED)
                            <h5 class="text-center mb30">La póliza fue enviada por e-mail a {{ $contract->contact_email }}.</h5>
                        @endif
                        
                    @elseif ($paymentReq->status == \App\PaymentRequest::STATUS_CANCELED)
                        <i class="fa fa-times round box-icon-large box-icon-center box-icon-success mb30"></i>  
                        <h2 class="text-center">El pago ha fallado</h2>
                        <h5 class="text-center mb30">Vuelve a intentarlo desde aqui.</h5>
                    @endif
                    
                </div>
                
            </div>
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
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

        <h3 style="text-align: center">No se encontró la contratación</h3>

        @endif
        
        
@endsection


@section('custom-js')
@endsection