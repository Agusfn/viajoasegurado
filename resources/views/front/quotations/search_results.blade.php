@extends('front.layouts.main2')

@section('content')
        <div class="container">
            
            <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                <h3>Search for Flight</h3>
                FORMULARIO
            </div>

            
            

            <div class="row" id="search-results">
                
                <h3 class="booking-title"><span id="title">12 seguros desde Argentina a América del Norte</span><small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Cambiar búsqueda</a></small></h3>

                <div class="col-md-12">
                    <div class="nav-drop booking-sort">
                        <h5 class="booking-sort-title"><a href="#">Sort: Sort: Price (low to high)<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
                        <ul class="nav-drop-menu">
                            <li><a href="#">Price (high to low)</a>
                            </li>
                            <li><a href="#">Duration</a>
                            </li>
                            <li><a href="#">Stops</a>
                            </li>
                            <li><a href="#">Arrival</a>
                            </li>
                            <li><a href="#">Departure</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="booking-list">
                        


                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="https://cdn.aseguratuviaje.com/repositorio/proveedor/165/gotravel.png" alt="Image Alternative text" title="Image Title" />
                                                <p>Go! Travel Assistance</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-xs-7"><i class="fa fa-ambulance insurance-icon" aria-hidden="true"></i> Cobertura por accidentes</div>
                                                <div class="col-xs-5"><h5>$800</h5></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7"><i class="fa fa-plus-square insurance-icon" aria-hidden="true"></i> Cobertura por enfermedad</div>
                                                <div class="col-xs-5"><h5>$800</h5></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7"><i class="fa fa-suitcase insurance-icon" aria-hidden="true"></i> Cobertura por equipaje</div>
                                                <div class="col-xs-5"><h5>$800</h5></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <a href=""><i class="fa fa-file-text-o" aria-hidden="true"></i> Ver términos y condiciones</a>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$447</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: Business</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Detalles del seguro</p>
                                            <h5 class="list-title">London (LHR) to Charlotte (CLT)</h5>
                                            <ul class="list">
                                                <li>US Airways 731</li>
                                                <li>Economy / Coach Class ( M), AIRBUS INDUSTRIE A330-300</li>
                                                <li>Depart 09:55 Arrive 15:10</li>
                                                <li>Duration: 9h 15m</li>
                                            </ul>
                                            <h5>Stopover: Charlotte (CLT) 7h 1m</h5>
                                            <h5 class="list-title">Charlotte (CLT) to New York (JFK)</h5>
                                            <ul class="list">
                                                <li>US Airways 1873</li>
                                                <li>Economy / Coach Class ( M), Airbus A321</li>
                                                <li>Depart 22:11 Arrive 23:53</li>
                                                <li>Duration: 1h 42m</li>
                                            </ul>
                                            <p>Total trip time: 17h 58m</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>


                        

                    </ul>
                    <p class="text-right">Not what you're looking for? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Try your search again</a>
                    </p>
                </div>
            </div>

            <div id="loading">
                <div class="spinner-clock spinner-dark">
                    <div class="spinner-clock-hour"></div>
                    <div class="spinner-clock-minute"></div>
                </div>
                <h2 class="mb5">Buscando coberturas para tu viaje</h2>
                <p class="text-bigger">tomará algunos segundos</p>
            </div>

            <div class="gap"></div>
        </div>
@endsection




@section('custom-js')
<meta name="url-code" content="{{ $url_code }}" />
<meta name="req-url" content="{{ url()->to('quotation/getquotation') }}" />
<script src="{{ asset('front/js/quotation-results-pg.js') }}"></script>
@endsection