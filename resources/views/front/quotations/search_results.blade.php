@extends('front.layouts.main')

@section('title', __('front/quote_results.title'))


@section('meta-tags')
    <meta name="robots" content="noindex, nofollow"> 
@endsection


@section('content')
        <div class="container">
            
            <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                @include('front.layouts.request-quotation-form')
            </div>
            
                
            @if ($quotationFound)

                @if (!$quotationExpired)

                <h4 style="text-align: center; margin-top: 80px; display: none" id="error-loading">Ocurrió un error cargando los resultados. <a href="javascript:location.reload();">Recarga la página</a> para reintentar.</h4>

                <div id="no-results-found" style="display: none; text-align: center;">
                    <div class="gap"></div><div class="gap"></div>
                    <h3 >{{ __('front/quote_results.no_results') }}</h3>
                    <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">{{ __('front/quote_results.search_again') }}</a>
                    <div class="gap"></div><div class="gap"></div><div class="gap"></div>
                </div>

                <div id="search-results" style="display: none">

                    <div class="booking-title">
                        <h3 id="title"><span id="product-count"></span> {{ __('front/quote_results.insurances_from') }} <span id="country-from"></span> {{ __('front/quote_results.to') }} <span id="region-to"></span></h3>
                        <span>{{ __('front/quote_results.time_from') }} <span id="trip-date-from"></span> {{ __('front/quote_results.time_to') }} <span id="trip-date-to"></span>, <span id="passg-count"></span> {{ __('front/quote_results.travelers') }}</span>
                        <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">{{ __('front/quote_results.change_search') }}</a></small>
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
                                            <h5 class="insurance-product-name">{{ __('front/quote_results.product_name') }}</h5>
                                            <div class="row">
                                                <div class="col-xs-7"><i class="fa fa-ambulance insurance-icon" aria-hidden="true"></i> {{ __('front/quote_results.accident_coverage') }}</div>
                                                <div class="col-xs-5"><span class="accident-coverage"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7"><i class="fa fa-plus-square insurance-icon" aria-hidden="true"></i> {{ __('front/quote_results.disease_coverage') }}</div>
                                                <div class="col-xs-5"><span class="disease-coverage"></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7"><i class="fa fa-suitcase insurance-icon" aria-hidden="true"></i> {{ __('front/quote_results.baggage_coverage') }}</div>
                                                <div class="col-xs-5"><span class="baggage-coverage"></span></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="insurance-terms-url" href="" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> {{ __('front/quote_results.view_terms') }}</a>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="booking-item-price"></span>&nbsp;<span class="insurance-currency"></span>
                                            <br/>
                                            <a class="btn btn-primary select-insurance-btn" href="">{{ __('front/quote_results.select') }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5>{{ __('front/quote_results.coverage_details') }}</h5>
                                            <p class="coverage-details"></p>
                                        </div>
                                    </div>
                                    <div class="coverage-loading"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></div>
                                </div>
                            </div>
                        </li>

                    </ul>

                    <p class="text-right">{{ __('front/quote_results.cant_find') }} <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">{{ __('front/quote_results.search_again') }}</a>
                    </p>
                </div>

                <div id="loading">
                    <div class="spinner-clock spinner-dark">
                        <div class="spinner-clock-hour"></div>
                        <div class="spinner-clock-minute"></div>
                    </div>
                    <h2 class="mb5">{{ __('front/quote_results.searching_coverages') }}</h2>
                    <p class="text-bigger">{{ __('front/quote_results.taking_seconds') }}</p>
                </div>

                @else
                <h4 style="text-align: center; margin-top: 100px">{{ __('front/quote_results.quotation_expired') }}<br/>
                <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">{{ __('front/quote_results.try_search_again') }}</a></small></h4>
                @endif

            @else
                <h4 style="text-align: center; margin-top: 100px">{{ __('front/quote_results.quotation_not_found') }}<br/>
                <small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">{{ __('front/quote_results.try_search_again') }}</a></small></h4>
            @endif

            <div class="gap"></div>
        </div>
@endsection




@section('custom-js')

<script>
    var countries_from = '@php echo json_encode($countries_from) @endphp';
    var lang = "{{ \App::getLocale() }}";
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