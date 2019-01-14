@extends('front.layouts.main')       

@section('title', __('front/home.title'))

@php ($section = 'home') @endphp



@section('custom-css')
<style>

.slick-slide {
    margin: 0px 20px;
}

.slick-slide img {
    width: 100%;
}

.slick-slider
{
    position: relative;
    display: block;
    box-sizing: border-box;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
            user-select: none;
    -webkit-touch-callout: none;
    -khtml-user-select: none;
    -ms-touch-action: pan-y;
        touch-action: pan-y;
    -webkit-tap-highlight-color: transparent;
}

.slick-list
{
    position: relative;
    display: block;
    overflow: hidden;
    margin: 0;
    padding: 0;
}
.slick-list:focus
{
    outline: none;
}
.slick-list.dragging
{
    cursor: pointer;
    cursor: hand;
}

.slick-slider .slick-track,
.slick-slider .slick-list
{
    -webkit-transform: translate3d(0, 0, 0);
       -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
         -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
}

.slick-track
{
    position: relative;
    top: 0;
    left: 0;
    display: block;
}
.slick-track:before,
.slick-track:after
{
    display: table;
    content: '';
}
.slick-track:after
{
    clear: both;
}
.slick-loading .slick-track
{
    visibility: hidden;
}

.slick-slide
{
    display: none;
    float: left;
    height: 100%;
    min-height: 1px;
}
[dir='rtl'] .slick-slide
{
    float: right;
}
.slick-slide img
{
    width: auto;
    max-width: 100%;
    max-height: 60px;
    display: block;
    margin: 0 auto;
}
.slick-slide.slick-loading img
{
    display: none;
}
.slick-slide.dragging img
{
    pointer-events: none;
}
.slick-initialized .slick-slide
{
    display: block;
}
.slick-loading .slick-slide
{
    visibility: hidden;
}
.slick-vertical .slick-slide
{
    display: block;
    height: auto;
    border: 1px solid transparent;
}
.slick-arrow.slick-hidden {
    display: none;
}
</style>
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
                                    <!--h1>Find Your Perfect Trip</h1-->

                                            
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
                    <div class="slide"><img src="{{ asset('front/img/partners/allianz.jpg') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/europ-assistance.jpg') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/assist-card.jpg') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/assist-365.jpg') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/assist-med.jpg') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/axa-assistance.png') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/euroamerican-assistance.png') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/go-travel-assistance.png') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/latin-assistance.png') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/travel-ace.jpg') }}"></div>
                    <div class="slide"><img src="{{ asset('front/img/partners/international-assist.png') }}"></div>
                </section>
            </div>
            <div class="gap"></div>
        </div>


@endsection



@section('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script>
    var countries_from = '@php echo json_encode($countries_from) @endphp';
    $(document).ready(function(){
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
<script src="{{ asset('front/js/home-pg.js') }}"></script>
<script src="{{ asset('front/js/quotation-form.js') }}"></script>
@endsection