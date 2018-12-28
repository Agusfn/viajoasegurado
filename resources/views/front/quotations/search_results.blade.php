@extends('front.layouts.main2')

@section('content')
        <div class="container">
            
            <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                <h3>Search for Flight</h3>
                @include('front.layouts.request-quotation-form')
            </div>
            
                
            @if ($quotationFound)

                @if (!$quotationExpired)
                <div id="search-results" style="display: none">

                    <div class="booking-title">
                        <h3 id="title"><span id="product-count"></span> seguros para viaje desde <span id="country-from"></span> a <span id="region-to"></span></h3>
                        <span>Desde el <span id="trip-date-from"></span> hasta el <span id="trip-date-to"></span>, <span id="passg-count"></span> pasajero/s</span>
                        <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Cambiar búsqueda</a></small>
                    </div>

                    <ul class="booking-list" id="insurance-list">

                        <li id="copy-quote-element" style="display: none">
                            <div class="booking-item-container" data-product-id="">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img class="insurer-img" src="" alt="" />
                                                <p class="insurer-name"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <h5 class="insurance-product-name">Nombre del producto</h5>
                                            <div class="row">
                                                <div class="col-xs-7"><i class="fa fa-ambulance insurance-icon" aria-hidden="true"></i> Cobertura por accidentes</div>
                                                <div class="col-xs-5"><span class="accident-coverage"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7"><i class="fa fa-plus-square insurance-icon" aria-hidden="true"></i> Cobertura por enfermedad</div>
                                                <div class="col-xs-5"><span class="disease-coverage"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7"><i class="fa fa-suitcase insurance-icon" aria-hidden="true"></i> Cobertura por equipaje</div>
                                                <div class="col-xs-5"><span class="baggage-coverage"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="insurance-terms-url" href="" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> Ver términos y condiciones</a>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="booking-item-price"></span>&nbsp;<span class="insurance-currency">/person</span>
                                            <br/>
                                            <a class="btn btn-primary select-insurance-btn" href="">Seleccionar</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5>Detalles de la cobertura del seguro</h5>
                                            <p class="coverage-details"></p>
                                        </div>
                                    </div>
                                    <div class="coverage-loading"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></div>
                                </div>
                            </div>
                        </li>


                    </ul>

                    <p class="text-right">¿No encuentras lo que estás buscando? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Realizá tu búsqueda nuevamente</a>
                    </p>
                </div>

                <div id="loading">
                    <div class="spinner-clock spinner-dark">
                        <div class="spinner-clock-hour"></div>
                        <div class="spinner-clock-minute"></div>
                    </div>
                    <h2 class="mb5">Buscando coberturas para tu viaje</h2>
                    <p class="text-bigger">tomará algunos segundos</p>
                </div>

                @else
                <h4 style="text-align: center; margin-top: 100px">La cotización expiró<br/>
                <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Vuelve a hacer otra búsqueda</a></small></h4>
                @endif

            @else
                <h4 style="text-align: center; margin-top: 100px">No se encontró la cotización solicitada<br/>
                <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Hacer otra búsqueda</a></small></h4>
            @endif

            <div class="gap"></div>
        </div>
@endsection




@section('custom-js')

<script>
    var countries_from = '@php echo json_encode($countries_from) @endphp';
</script>
<script src="{{ asset('front/js/quotation-form.js') }}"></script>

@if ($quotationFound && !$quotationExpired)
<meta name="url-code" content="{{ $url_code }}" />
<meta name="get-quot-url" content="{{ URL::to('quotation/getquotation') }}" />
<meta name="get-coverage-url" content="{{ URL::to('quotation/getproductcoverage') }}" />
<meta name="contract-form-url" content="{{ URL::to(uri_localed('{contract}')) }}" />

<script src="{{ asset('front/js/quotation-results-pg.js') }}"></script>
@endif


@endsection