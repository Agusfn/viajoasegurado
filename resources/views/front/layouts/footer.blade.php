		<footer id="main-footer">
            <div class="container">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <a class="logo" href="{{ url(uri_localed('')) }}">
                            <img src="{{ asset('front/img/logo3bw.png') }}" alt="{{ config('app.name') }}" style="max-width: 200px" />
                        </a>
                        <p class="mb20">{{ __('front/shared/main.footer_company_description') }}</p>
                        <p>Viajoasegurado © 2019</p>

                    </div>

                    <div class="col-md-3">
                        
                        <h4>Prestaciones</h4>
                        <ul class="list list-footer">
                            <li><a href="{{ url(uri_localed('{insurance}/{longs_stay_student}')) }}">{{ __("front/shared/main.nav_insurance_long_stay_student") }}</a></li>
                            <li><a href="{{ url(uri_localed('{insurance}/{multi_trip}')) }}">{{ __("front/shared/main.nav_insurance_multi_trip") }}</a></li>
                            <li><a href="{{ url(uri_localed('{insurance}/{it_insurance}')) }}">{{ __("front/shared/main.nav_insurance_technology") }}</a></li>
                            <li><a href="{{ url(uri_localed('{insurance}/{sports_insurance}')) }}">{{ __("front/shared/main.nav_insurance_sports") }}</a></li>
                            <li><a href="{{ url(uri_localed('{insurance}/{cancellation_insurance}')) }}">{{ __("front/shared/main.nav_insurance_cancellation") }}</a></li>
                            <li><a href="{{ url(uri_localed('{insurance}/{chronic_disease_senior_insurance}')) }}">{{ __("front/shared/main.nav_insurance_chronic_disease_senior") }}</a></li>
                            <li><a href="{{ url(uri_localed('{insurance}/{pregnant_insurance}')) }}">{{ __("front/shared/main.nav_insurance_pregnant") }}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <h4>Páginas</h4>
                        <ul class="list list-footer">
                            <li><a href="{{ url(uri_localed('{support}')) }}">{{ __('front/shared/main.footer_contact') }}</a></li>
                            <li><a href="{{ url(uri_localed('{about_us}')) }}">{{ __('front/shared/main.footer_about_us') }}</a></li>
                            <li><a href="{{ url(uri_localed('{terms}')) }}">{{ __('front/shared/main.footer_terms_and_conditions') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>{{ __('front/shared/main.footer_need_help') }}</h4>
                        <ul class="list list-footer contact-list">
                            <li><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;&nbsp;<a href="mailto:{{ __('front/support.contact_email') }}" class="text-color">{{ __('front/support.contact_email') }}</a></li>
                            <li><i class="fa fa-whatsapp" aria-hidden="true"></i>&nbsp;&nbsp;+54 11 41460319</h4></li>
                        </ul>

                        <ul class="list list-horizontal list-space" style="margin-top: 30px">
                            <li>
                                <a class="fa fa-facebook box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-linkedin box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </footer>