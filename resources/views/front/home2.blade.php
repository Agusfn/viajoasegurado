@extends('front.layouts.main2')       


@section('title', 'titulo')


@section('custom-css')

@endsection



@section('content')
        
        <!-- TOP AREA -->
        <div class="top-area show-onload" style="height: 1200px">
            <div class="bg-holder full">
                <div class="bg-mask"></div>
                <div class="bg-parallax" style="background-image:url({{ asset('front/img/backgrounds/road.jpg') }});"></div>
                <div class="bg-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="search-tabs search-tabs-bg mt50">
                                    <h1>Find Your Perfect Trip</h1>

                                            
                                    <div style="background: #fff;padding: 25px;-webkit-box-shadow: 0 2px 1px rgba(0,0,0,0.15);box-shadow: 0 2px 1px rgba(0,0,0,0.15);">
                                        <h2 style="margin-bottom: 25px">Buscar seguros</h2>
                                        
                                        {{ Form::open( array("url" => uri_localed("quotation/create"), "method" => "post", "id" => "quote-form") ) }}
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                        <label>Desde</label>
                                                        <input type="text" class="typeahead form-control" id="country-from-input" placeholder="País" data-provide="typeahead" autocomplete="off" />
                                                        <input type="hidden" name="country_code_from">
                                                        <label class="form-error" id="country-from-error">Selecciona un país válido</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
                                                        <label>Hacia</label>
                                                        <select class="form-control" name="region_code_to">
                                                            <option>Seleccionar</option>
                                                            @foreach($regions_to as $region)
                                                            <option value="{{ $region["id"] }}">{{ $region["name"] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <label class="form-error" id="region-to-error">Selecciona un destino</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-daterange" data-date-format="M d, D">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                            <label>Fecha salida</label>
                                                            <input class="form-control" name="date_start" type="text" data-date-format="dd/mm/yyyy" />
                                                            <label class="form-error" id="date-start-error">Selecciona una fecha válida mayor a hoy</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
                                                            <label>Fecha vuelta</label>
                                                            <input class="form-control" name="date_end" type="text" data-date-format="dd/mm/yyyy" />
                                                            <label class="form-error" id="date-end-error">Selecciona una fecha válida después de la fecha de salida</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="padding-top: 28px">
                                                            <label><input type="checkbox" class="icheckbox" name="travel_pregnant"> El seguro es para una mujer embarazada</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-lg">
                                                        <label>Pasajeros</label>
                                                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                                            <label class="btn btn-primary active" id="passg-ammt-1">
                                                                <input type="radio" name="passenger_ammount" value="1" />1
                                                            </label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="passenger_ammount" value="2" />2
                                                            </label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="passenger_ammount" value="3" />3
                                                            </label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="passenger_ammount" value="4" />4
                                                            </label>
                                                            <label class="btn btn-primary">
                                                                <input type="radio" name="passenger_ammount" value="5" />5
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-lg" style="display: inline-block;">
                                                        <label>Edades</label>
                                                        <input type="text" class="form-control short-input" name="age1" id="age1-input">&nbsp;
                                                        <input type="text" class="form-control short-input" name="age2" id="age2-input" style="display: none;">&nbsp;
                                                        <input type="text" class="form-control short-input" name="age3" id="age3-input" style="display: none;">&nbsp;
                                                        <input type="text" class="form-control short-input" name="age4" id="age4-input" style="display: none;">&nbsp;
                                                        <input type="text" class="form-control short-input" name="age5" id="age5-input" style="display: none;">&nbsp;
                                                        <label class="form-error" id="ages-error">Ingresa edades numéricas válidas</label>
                                                    </div>
                                                    <div class="form-group form-group-lg" id="gestation-weeks-form-group">
                                                        <label>Semanas de gestación</label>
                                                        <input type="text" name="gestation_weeks" class="form-control short-input">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-lg">
                                                        <label>E-mail</label>
                                                        <input type="text" class="form-control" name="email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="text-align: right;">
                                                    <button type="button" class="btn btn-primary btn-lg" id="submit-quote-btn" style="margin-top: 27px">Cotizar</button>
                                                </div>
                                            </div>


                                            
                                        {{ Form::close() }}
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
                        <header class="thumb-header"><i class="fa fa-briefcase box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#">Combine & Save</a></h5>
                            <p class="thumb-desc">Sagittis non laoreet augue nulla lectus auctor accumsan cubilia sollicitudin mattis leo</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb">
                        <header class="thumb-header"><i class="fa fa-thumbs-o-up box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#">Best Travel Agent</a></h5>
                            <p class="thumb-desc">Vel morbi class sollicitudin cubilia quisque penatibus dictumst faucibus dui natoque ultricies</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="thumb">
                        <header class="thumb-header"><i class="fa fa-lock box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#">Trust & Safety</a></h5>
                            <p class="thumb-desc">Montes congue pellentesque aliquet lectus dictum est volutpat class odio elementum quis</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap gap-small"></div>
        </div>
        <div class="bg-holder">
            <div class="bg-mask"></div>
            <div class="bg-parallax" style="background-image:url({{ asset('front/img/backgrounds/bridge.jpg') }});"></div>
            <div class="bg-content">
                <div class="container">
                    <div class="gap gap-big text-center text-white">
                        <h2 class="text-uc mb20">Last Minute Deal</h2>
                        <ul class="icon-list list-inline-block mb0 last-minute-rating">
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                            <li><i class="fa fa-star"></i>
                            </li>
                        </ul>
                        <h5 class="last-minute-title">The Peninsula - New York</h5>
                        <p class="last-minute-date">Fri 14 Mar - Sun 16 Mar</p>
                        <p class="mb20"><b>$120</b> / person</p><a class="btn btn-lg btn-white btn-ghost" href="#">Book Now <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="gap"></div>
            <h2 class="text-center">Top Destinations</h2>
            <div class="gap">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img src="{{ asset('front/img/800x600.png') }}" alt="Image Alternative text" title="Upper Lake in New York Central Park" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
                                </a>
                            </header>
                            <div class="thumb-caption">
                                <h4 class="thumb-title">USA</h4>
                                <p class="thumb-desc">Scelerisque montes class curabitur class aenean aliquam eu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img src="{{ asset('front/img/800x600.png') }}" alt="Image Alternative text" title="lack of blue depresses me" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
                                </a>
                            </header>
                            <div class="thumb-caption">
                                <h4 class="thumb-title">Greece</h4>
                                <p class="thumb-desc">Condimentum odio eget curabitur scelerisque vivamus ipsum congue</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img src="{{ asset('front/img/800x600.png') }}" alt="Image Alternative text" title="people on the beach" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
                                </a>
                            </header>
                            <div class="thumb-caption">
                                <h4 class="thumb-title">Australia</h4>
                                <p class="thumb-desc">Ornare cras scelerisque volutpat nulla porttitor commodo cubilia</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="thumb">
                            <header class="thumb-header">
                                <a class="hover-img curved" href="#">
                                    <img src="{{ asset('front/img/400x300.png') }}" alt="Image Alternative text" title="the journey home" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
                                </a>
                            </header>
                            <div class="thumb-caption">
                                <h4 class="thumb-title">Africa</h4>
                                <p class="thumb-desc">Dictumst risus montes ipsum faucibus vel sodales cubilia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


@endsection



@section('custom-js')
<script>
    var countries_from = '@php echo json_encode($countries_from) @endphp';
</script>
<script src="{{ asset('front/js/home-pg.js') }}"></script>
@endsection