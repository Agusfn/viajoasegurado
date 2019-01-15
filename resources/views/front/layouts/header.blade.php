        <header id="main-header">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <a class="logo" href="{{ url('') }}">
                                <img src="{{ asset('img/logo3.png') }}" alt="{{ config('app.name') }}" style="width:177px" />
                            </a>
                        </div>
                        <div class="col-md-8">
                            <ul class="slimmenu" id="slimmenu">
                                <li @if(@$section == 'home') class="active" @endif><a href="{{ url('') }}">{{ __("front/shared/main.nav_home") }}</a></li>
                                <li @if(@$section == 'support') class="active" @endif><a href="{{ url(uri_localed('{support}')) }}">{{ __("front/shared/main.nav_support") }}</a></li>
                                <li @if(@$section == 'insurers') class="active" @endif><a href="#">{{ __("front/shared/main.nav_insurances") }}</a>
                                    <ul>
                                        <li><a href="{{ url(uri_localed('{insurer}/assist-card')) }}">Assist Card</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/universal-assistance')) }}">Universal Assistance</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/coris')) }}">Coris</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/axa-assistance')) }}">AXA Assistance</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/cardinal-assistance')) }}">Cardinal Assistance</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/europ-assistance')) }}">Europ Assistance</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/travel-ace')) }}">Travel Ace</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/assist-365')) }}">Assist 365</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/latin-assistance')) }}">Latin Assistance</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/international-assist')) }}">International Assist</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/euroamerican-assistance')) }}">Euroamerican Assistance</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/go-travel-assistance')) }}">Go Travel Assistance</a></li>
                                        <li><a href="{{ url(uri_localed('{insurer}/allianz-assistance')) }}">Allianz Assistance</a></li>
                                    </ul>
                                </li>
                                <li @if(@$section == 'assistances') class="active" @endif><a href="#">{{ __("front/shared/main.nav_assistance") }}</a>
                                    <ul>
                                        <li><a href="feature-typography.html">Typography</a>
                                        </li>
                                        <li><a href="feature-icons.html">Icons</a>
                                        </li>
                                        <li><a href="feature-forms.html">Forms</a>
                                        </li>
                                        <li><a href="feature-icon-effects.html">Icon Effects</a>
                                        </li>
                                        <li><a href="feature-elements.html">Elements</a>
                                        </li>
                                        <li><a href="feature-grid.html">Grid</a>
                                        </li>
                                        <li><a href="feature-hovers.html">Hover effects</a>
                                        </li>
                                        <li><a href="feature-lightbox.html">Lightbox</a>
                                        </li>
                                        <li><a href="feature-media.html">Media</a>
                                        </li>
                                    </ul>
                                </li>
                                <li @if(@$section == 'about') class="active" @endif><a href="{{ url(uri_localed('{about_us}')) }}">{{ __("front/shared/main.nav_about_us") }}</a></li>
                            </ul>
                        </div>
                        <div class="col-md-1">
                            <div class="top-user-area clearfix">
                                <ul class="top-user-area-list list list-horizontal list-border">
                                    <li class="top-user-area-lang nav-drop">
                                        

                                        <a href="#">
                                            <img src="{{ asset('front/img/lang_flags/'.App::getLocale().'.png') }}" alt="Image Alternative text" title="Image Title" />{{ App::isLocale('es') ? "ESP" : "ENG "}}<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i>
                                        </a>

                                        <ul class="list nav-drop-menu">
                                            <li>
                                                <a title="Spanish" href="{{ url("lang?code=es") }}" onclick="window.location.assign('{{ url("lang?code=es") }}');">
                                                    <img src="{{ asset('front/img/flags/32/es.png') }}" alt="Image Alternative text" title="Image Title" /><span class="right">ESP</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="English" href="{{ url('lang?code=en') }}" onclick="window.location.assign('{{ url("lang?code=en") }}');">
                                                    <img src="{{ asset('front/img/flags/32/uk.png') }}" alt="Image Alternative text" title="Image Title" /><span class="right">ENG</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--div class="container">
                <div class="nav">
                    
                </div>
            </div-->
        </header>