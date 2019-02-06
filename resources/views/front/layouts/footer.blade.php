		<footer id="main-footer">
            <div class="container">
                <div class="row row-wrap">
                    <div class="col-md-3">
                        <a class="logo" href="{{ url(uri_localed('')) }}">
                            <img src="{{ asset('front/img/logo3bw.png') }}" alt="{{ config('app.name') }}" style="max-width: 200px" />
                        </a>
                        <p class="mb20">{{ __('front/shared/main.footer_company_description') }}</p>
                    </div>

                    <div class="col-md-3">
                        <ul class="list list-horizontal list-space">
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
                    <div class="col-md-2">
                        <ul class="list list-footer">
                            <li><a href="{{ url(uri_localed('{terms}')) }}">{{ __('front/shared/main.footer_terms_and_conditions') }}</a></li>
                            <li><a href="{{ url(uri_localed('{support}')) }}">{{ __('front/shared/main.footer_contact') }}</a></li>
                            <li><a href="{{ url(uri_localed('{about_us}')) }}">{{ __('front/shared/main.footer_about_us') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>{{ __('front/shared/main.footer_contact') }}</h4>
                        <h4 class="text-color"><i class="fa fa-whatsapp" aria-hidden="true"></i> +54 9 11 4146 0319</h4>
                        <h4><a href="mailto:{{ __('front/support.contact_email') }}" class="text-color">{{ __('front/support.contact_email') }}</a></h4>
                    </div>

                </div>
            </div>
        </footer>