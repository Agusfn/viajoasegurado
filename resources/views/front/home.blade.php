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
                            <div class="col-md-7">
                                <div class="search-tabs search-tabs-bg" style="margin-top: 20px">
                                    <div style="background: #fff;padding: 25px;-webkit-box-shadow: 0 2px 1px rgba(0,0,0,0.15);box-shadow: 0 2px 1px rgba(0,0,0,0.15);">
                                        @include('front.layouts.request-quotation-form')
                                    </div>
                                </div>
                                <div class="gap gap-small hidden-sm"></div>
                            </div>
                            <div class="col-md-5">
                                
                                <div class="gap hidden-xs"></div>

                                <section class="main-slider slider">
                                    @if(App::isLocale('es'))
                                    <div class="slide"><img src="{{ asset('front/img/main_slider/es/home_quotation_slider_1.png') }}"></div>
                                    <div class="slide"><img src="{{ asset('front/img/main_slider/es/home_quotation_slider_2.png') }}"></div>
                                    @elseif (App::isLocale('en'))
                                    <div class="slide"><img src="{{ asset('front/img/main_slider/en/home_quotation_slider_1.png') }}"></div>
                                    <div class="slide"><img src="{{ asset('front/img/main_slider/en/home_quotation_slider_2.png') }}"></div>
                                    <div class="slide"><img src="{{ asset('front/img/main_slider/en/home_quotation_slider_3.png') }}"></div>
                                    @endif
                                </section>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END TOP AREA  -->

        <div class="container">
            <div class="gap gap-small"></div>
            
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
            
            <h2 class="text-center" style="margin-bottom: 45px">{{ __('front/home.travel_assistance') }}</h2>

            <div class="row row-wrap" data-gutter="60">
                <div class="col-md-4">
                    <div class="thumb">
                        <i class="fa fa-clock-o box-icon-md round box-icon-black box-icon-left animate-icon-top-to-bottom"></i>
                        <div class="thumb-caption">
                            <h5 class="thumb-title">{{ __("front/home.24hs_assistance") }}</h5>
                            <p class="thumb-desc">{{ __("front/home.24hs_assistance_description") }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb">
                        <i class="fa fa-shield box-icon-md round box-icon-black box-icon-left animate-icon-top-to-bottom"></i>
                        <div class="thumb-caption">
                            <h5 class="thumb-title">{{ __("front/home.travel_protection") }}</h5>
                            <p class="thumb-desc">{{ __("front/home.travel_protection_description") }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb">
                        <i class="fa fa-rocket box-icon-md round box-icon-black box-icon-left animate-icon-top-to-bottom"></i>
                        <div class="thumb-caption">
                            <h5 class="thumb-title">{{ __("front/home.quick_easy") }}</h5>
                            <p class="thumb-desc">{{ __("front/home.quick_easy_description") }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gap gap-small"></div>
        </div>

        <div class="container">

            <div class="gap gap-small"></div>

            <div class="row">

                <div class="col-lg-3 col-sm-6">
                    <img src="{{ asset('front/img/medicine.jpg') }}" />
                    <h4 style="margin-top: 15px">{{ __("front/home.medical_assistance") }}</h4>
                    <p>{{ __("front/home.medical_assistance_desc") }}</p>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <img src="{{ asset('front/img/luggage.jpg') }}" />
                    <h4 style="margin-top: 15px">{{ __("front/home.flights_assistance") }}</h4>
                    <p>{{ __("front/home.flights_assistance_desc") }}</p>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <img src="{{ asset('front/img/legal.jpg') }}" />
                    <h4 style="margin-top: 15px">{{ __("front/home.legal_assistance") }}</h4>
                    <p>{{ __("front/home.legal_assistance_desc") }}</p>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <img src="{{ asset('front/img/ski.jpg') }}" />
                    <h4 style="margin-top: 15px">{{ __("front/home.sport_assistance") }}</h4>
                    <p>{{ __("front/home.sport_assistance_desc") }}</p>
                </div>

            </div>

            <div class="gap"></div>

        </div>

        <div class="bg-holder">
            <div class="bg-mask"></div>
            <div class="bg-parallax" style="background-image:url({{ asset('front/img/bg2.jpg') }});"></div>
            <div class="bg-content">
                <div class="container">
                    
                    <div class="gap gap-small"></div>
                    <h1 class="text-center text-white mb20">{{ __('front/home.customer_reviews') }}</h1>
                    <div class="row row-wrap">
                        <div class="col-md-4">
                            <!-- START TESTIMONIAL -->
                            <div class="testimonial text-white">
                                <div class="testimonial-inner">
                                    <blockquote>
                                        <p>Eget penatibus hac tortor imperdiet ante elementum tellus vel habitant in laoreet aenean sapien penatibus</p>
                                    </blockquote>
                                </div>
                                <div class="testimonial-author">
                                    <img src="{{ asset('front/img/testimonios/215645765.jpg') }}" style="width: 60px" alt="Testimonio" title="Sevenly Shirts - June 2012  2" />
                                    <p class="testimonial-author-name">Maximiliano</p><cite>de Argentina</cite>
                                </div>
                            </div>
                            <!-- END TESTIMONIAL -->
                        </div>
                        <div class="col-md-4">
                            <!-- START TESTIMONIAL -->
                            <div class="testimonial text-white">
                                <div class="testimonial-inner">
                                    <blockquote>
                                        <p>Netus cum ornare massa blandit natoque dui volutpat lacus non volutpat enim praesent lobortis semper</p>
                                    </blockquote>
                                </div>
                                <div class="testimonial-author">
                                    <img src="{{ asset('front/img/50x50.png') }}" alt="Image Alternative text" title="Flare lens flare" />
                                    <p class="testimonial-author-name">Joaquín</p><cite>on <a class="text-udl" href="#">Wellington</a> hotel in New York</cite>
                                </div>
                            </div>
                            <!-- END TESTIMONIAL -->
                        </div>
                        <div class="col-md-4">
                            <!-- START TESTIMONIAL -->
                            <div class="testimonial text-white">
                                <div class="testimonial-inner">
                                    <blockquote>
                                        <p>Aliquam vulputate velit penatibus elit gravida neque mollis purus vivamus habitasse iaculis nullam cras consectetur</p>
                                    </blockquote>
                                </div>
                                <div class="testimonial-author">
                                    <img src="{{ asset('front/img/50x50.png') }}" alt="Image Alternative text" title="Afro" />
                                    <p class="testimonial-author-name">Sarah Slater</p><cite>on <a class="text-udl" href="#">Holiday</a> hotel in New York</cite>
                                </div>
                            </div>
                            <!-- END TESTIMONIAL -->
                        </div>
                    </div>
                    <div class="gap-small gap"></div>

                </div>
            </div>
        </div>





@endsection



@section('custom-js')
<script src="{{ asset('front/js/vendor/slick.js?'.rand()) }}"></script>
<script>
    var countries_from = '@php echo json_encode($countries_from) @endphp';

    $(document).ready(function() {

        $('input.icheckbox').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'icheckbox_square-blue'
        });
        
        $('.customer-logos').slick({
            slidesToShow: 8,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 6
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 4
                }
            }]
        });

        $(".main-slider").slick({
            slidesToShow: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            speed: 1500
        });

    });

</script>
<script src="{{ asset('front/js/quotation-form.js?'.rand()) }}"></script>
@endsection