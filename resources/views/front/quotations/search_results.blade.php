@extends('front.layouts.main2')

@section('content')
        <div class="container">
            
            <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                <h3>Search for Flight</h3>
                FORMULARIO
            </div>

            <h3 class="booking-title"><span id="title">12 seguros desde Argentina a América del Norte</span><small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Cambiar búsqueda</a></small></h3>
            

            <div class="row" id="search-results" style="">
                
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
                                                <img src="img/american-airlines.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>American Airlines</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>non-stop</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$447</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: Business</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/lufthansa.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>Lufthansa</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>2 stops</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$180</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: Business</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/american-airlines.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>American Airlines</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>2 stops</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$446</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: First</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/lufthansa.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>Lufthansa</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>non-stop</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$463</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: Business</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/aircanada.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>Air Canada</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>1 stop</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$270</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: Business</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/airfrance.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>Airfrance</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>non-stop</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$198</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: Economy</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/croatia.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>Croatia Airlines</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>2 stops</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$476</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: First</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/lufthansa.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>Lufthansa</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>2 stops</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$475</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: Economy</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/american-airlines.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>American Airlines</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>1 stop</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$444</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: Business</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/airfrance.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>Airfrance</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>non-stop</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$476</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: First</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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
                        <li>
                            <div class="booking-item-container">
                                <div class="booking-item">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="booking-item-airline-logo">
                                                <img src="img/delta.jpg" alt="Image Alternative text" title="Image Title" />
                                                <p>Delta</p>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="booking-item-flight-details">
                                                <div class="booking-item-departure"><i class="fa fa-plane"></i>
                                                    <h5>10:25 PM</h5>
                                                    <p class="booking-item-date">Sun, Mar 22</p>
                                                    <p class="booking-item-destination">London, England, United Kingdom (LHR)</p>
                                                </div>
                                                <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-vertical"></i>
                                                    <h5>12:25 PM</h5>
                                                    <p class="booking-item-date">Sat, Mar 23</p>
                                                    <p class="booking-item-destination">New York, NY, United States (JFK)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>22h 50m</h5>
                                            <p>1 stop</p>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$490</span><span>/person</span>
                                            <p class="booking-item-flight-class">Class: Economy</p><a class="btn btn-primary" href="#">Select</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking-item-details">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>Flight Details</p>
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

            <div id="loading" style="text-align: center; display: none">
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
<script src="{{ asset('front/js/home-pg.js') }}"></script>
@endsection