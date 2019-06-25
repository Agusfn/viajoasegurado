@extends('front.layouts.main')

@if ($quotation && !$quotation->expired() && !$quotation->contracted())
    @section('title', __('front/quote_results.title')." ".$quotation->destinationName())
@else
    @section('title', 'Error')
@endif

@section('meta-tags')
    <meta name="robots" content="noindex, nofollow"> 
@endsection


@section('custom-css')
<style type="text/css">
    
.sidebar-quote-form {
    padding-top: 35px;
    padding-bottom: 35px;
    margin-top: 15px;
    background: rgba(53,134,171,1);
    background: -moz-linear-gradient(-45deg, rgba(53,134,171,1) 0%, rgba(38,84,110,1) 100%);
    background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(53,134,171,1)), color-stop(100%, rgba(38,84,110,1)));
    background: -webkit-linear-gradient(-45deg, rgba(53,134,171,1) 0%, rgba(38,84,110,1) 100%);
    background: -o-linear-gradient(-45deg, rgba(53,134,171,1) 0%, rgba(38,84,110,1) 100%);
    background: -ms-linear-gradient(-45deg, rgba(53,134,171,1) 0%, rgba(38,84,110,1) 100%);
    background: linear-gradient(135deg, rgba(53,134,171,1) 0%, rgba(38,84,110,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3586ab', endColorstr='#26546e', GradientType=1 );
    color: #FFF;
}

.sidebar-quote-form .form-group-lg .form-control {
    height: 40px ;
    padding-top: 5px ;
    padding-bottom: 5px ;
}

.sidebar-quote-form .form-group-lg .input-icon
{
    width: 40px;
    height: 40px;
    line-height: 40px;
    font-size: 20px;
}

.sidebar-quote-form .form-group-lg label {
    font-size: 14px;
    margin-bottom: 5px;
}

.sidebar-quote-form .form-group-lg {
    margin-bottom: 12px !important;
}

#age1-input, #age2-input, #age3-input, #age4-input, #age5-input {
    width: 40px;
    padding: 10px 7px;
}

.form-error {
    color: #fff;
}

.insurance-terms-url {
    font-size: 13px;
}

.booking-item-price {
    font-size: 30px;
}

.booking-item-airline-logo {
    text-align: center;
}
</style>
@endsection


@section('content')
        <div class="container">
            

            <div class="row">

                <div class="col-md-3 sidebar-quote-form" style="">

                    @include('front.quotations.sidebar-form')

                </div>


                <div class="col-md-9">
                    
                    @if ($quotation)

                        @if (!$quotation->expired() && !$quotation->contracted())

                        <h4 style="text-align: center; margin-top: 80px; display: none" id="error-loading">{{ __('front/quote_results.error_loading') }} <a href="javascript:location.reload();">{{ __('front/quote_results.reload_page') }}</a> {{ __('front/quote_results.to_retry') }}.</h4>

                        <div id="no-results-found" style="display: none; text-align: center;">
                            <div class="gap"></div><div class="gap"></div>
                            <h3 >{{ __('front/quote_results.no_results') }}</h3>
                            {{ __('front/quote_results.search_again') }}
                            <div class="gap"></div><div class="gap"></div><div class="gap"></div>
                        </div>

                        <div id="search-results" style="display: none">

                            <div class="booking-title">
                                <h3 id="title"><span id="product-count"></span> {{ __('front/quote_results.insurances_from') }} <span id="country-from"></span> {{ __('front/quote_results.to') }} <span id="region-to"></span></h3>
                                <span>{{ __('front/quote_results.time_from') }} <span id="trip-date-from"></span> {{ __('front/quote_results.time_to') }} <span id="trip-date-to"></span>, <span id="passg-count"></span> {{ __('front/quote_results.travelers') }}</span>
                            </div>

                            <ul class="booking-list" id="insurance-list">

                                <li id="copy-quote-element" style="display: none">
                                    <div class="booking-item-container" data-product-id="">
                                        <div class="booking-item">
                                            
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="booking-item-airline-logo">
                                                        <img class="insurer-img" src="" alt="" />
                                                        <p class="insurer-name"></p>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">

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

                                                <div class="col-md-3">
                                                    <span class="booking-item-price"></span>&nbsp;<span class="insurance-currency"></span>
                                                    <br/>
                                                    <a class="btn btn-primary btn-lg select-insurance-btn" href="">{{ __('front/quote_results.select') }}</a><br/>
                                                    <a class="insurance-terms-url" href="" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i> {{ __('front/quote_results.view_terms') }}</a>
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
                        <small>{{ __('front/quote_results.try_search_again') }}</small></h4>
                        @endif

                    @else
                        <h4 style="text-align: center; margin-top: 100px">{{ __('front/quote_results.quotation_not_found') }}<br/>
                        <small>{{ __('front/quote_results.try_search_again') }}</small></h4>
                    @endif

                </div>

            </div>


            <div class="gap"></div>

        </div>
@endsection




@section('custom-js')

<script>
    var countries_from = '@php echo json_encode($countries_from) @endphp';
    var lang = "{{ \App::getLocale() }}";
</script>
<script src="{{ asset('front/js/quotation-form.js') }}"></script>

@if ($quotation && !$quotation->expired() && !$quotation->contracted())
<meta name="url-code" content="{{ $quotation->url_code }}" />
<meta name="get-quot-url" content="{{ URL::to('quotation/getquotation') }}" />
<meta name="get-coverage-url" content="{{ URL::to('quotation/getproductcoverage') }}" />
<meta name="contract-form-url" content="{{ URL::to(uri_localed('{contract}')) }}" />

<script src="{{ asset('front/js/quotation-results-pg.js') }}"></script>
@endif


<script type="text/javascript">
    
    $(document).ready(function() {

        $('input.icheckbox').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'icheckbox_square-blue'
        });
        
        @if($quotation && $quotation->travelPregnant())
        $('.icheckbox').iCheck('check');
        @endif

    });

</script>

@endsection