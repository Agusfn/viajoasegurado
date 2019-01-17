@extends('front.layouts.main')       

@section('title', __('front/home.title'))

@php ($section = 'home') @endphp


@section('meta-tags')
    <meta name="robots" content="index, follow"> 
    <meta name="description" content="{{ __('front/home.meta_description') }}">
    <meta name="og:description" property="og:description" content="{{ __('front/home.meta_description') }}"> 
@endsection


@section('custom-css')
    <link rel="stylesheet" href="{{ asset('front/css/vendor/slick.css') }}">
@endsection



@section('content')
        
        <!-- TOP AREA -->
        <div class="top-area show-onload">
            <div class="bg-holder full">
                <div class="bg-mask"></div>
                <div class="bg-parallax" style="background-image:url({{ asset('front/img/bg1.jpg') }});"></div>
                <div class="bg-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="search-tabs search-tabs-bg mt50" id="aa">
                                    <div style="background: #fff;padding: 25px;-webkit-box-shadow: 0 2px 1px rgba(0,0,0,0.15);box-shadow: 0 2px 1px rgba(0,0,0,0.15);">
                                        @include('front.layouts.request-quotation-form')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END TOP AREA  -->

        <div class="gap"></div>


        <div class="container">
            <div class="row row-wrap" data-gutter="60">
                <div class="col-md-4">
                    <div class="thumb">
                        <header class="thumb-header"><i class="fa fa-clock-o box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#">{{ __("front/home.24hs_assistance") }}</a></h5>
                            <p class="thumb-desc">{{ __("front/home.24hs_assistance_description") }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb">
                        <header class="thumb-header"><i class="fa fa-shield box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#">{{ __("front/home.travel_protection") }}</a></h5>
                            <p class="thumb-desc">{{ __("front/home.travel_protection_description") }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb">
                        <header class="thumb-header"><i class="fa fa-rocket box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#">{{ __("front/home.quick_easy") }}</a></h5>
                            <p class="thumb-desc">{{ __("front/home.quick_easy_description") }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap gap-small"></div>
        </div>
        <div class="bg-holder">
            <div class="bg-mask"></div>
            <div class="bg-parallax" style="background-image:url({{ asset('front/img/bg2.jpg') }});"></div>
            <div class="bg-content">
                <div class="container">
                    <div style="height:400px"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="gap"></div>
            <h2 class="text-center">{{ __("front/home.our_insurers") }}</h2>
            
            <div class="gap">
                <section class="customer-logos slider">
                    <div class="slide"><img src="{{ asset('front/img/partners/allianz.jpg') }}" alt="Allianz"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/europ-assistance.jpg') }}" alt="Europ Assistance"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/assist-card.jpg') }}" alt="Assist Card"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/assist-365.jpg') }}" alt="Assist 365"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/assist-med.jpg') }}" alt="Assist Med"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/axa-assistance.png') }}" alt="Axa Assistance"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/euroamerican-assistance.png') }}" alt="Euroamerican Assistance"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/go-travel-assistance.png') }}" alt="Go Travel Assistance"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/latin-assistance.png') }}" alt="Latin Assistance"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/travel-ace.jpg') }}" alt="Travel Ace"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/international-assist.png') }}" alt="International Assist"></div>
                </section>
            </div>
            <div class="gap"></div>
        </div>


@endsection



@section('custom-js')
<script src="{{ asset('front/js/vendor/slick.js') }}"></script>
<script>
    var countries_from = '@php echo json_encode($countries_from) @endphp';

    $(document).ready(function() {

        $('input.icheckbox').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'icheckbox_square-blue'
        });
        
        $('.customer-logos').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 3
                }
            }]
        });
    });

</script>
<script src="{{ asset('front/js/quotation-form.js') }}"></script>
@endsection