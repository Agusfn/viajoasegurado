                    <div class="booking-item-payment">
                        <header class="clearfix">
                            <h5 class="mb0">{{ __('front/shared/contract-summary.details') }}</h5>
                        </header>
                        <ul class="booking-item-payment-details">
                            <li>
                                <h5>{{ __('front/shared/contract-summary.trip_details') }}</h5>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <small><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;{{ __('front/shared/contract-summary.origin') }}</small>
                                        <p>{{ __($quotation->country_from->name_english) }}</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <small><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;{{ __('front/shared/contract-summary.destination') }}</small>
                                        <p>{{ \App\Library\AseguratuViaje\ATV::getRegionName($quotation->destination_region_code) }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <small><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;{{ __('front/shared/contract-summary.from_date') }}</small>
                                        <p>{{ \App\Library\Dates::translate($quotation->date_from) }}</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <small><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;{{ __('front/shared/contract-summary.to_date') }}</small>
                                        <p>{{ \App\Library\Dates::translate($quotation->date_to) }}
                                        ({{ (new DateTime($quotation->date_to))->diff(new DateTime($quotation->date_from))->format("%a") }} {{ __('front/shared/contract-summary.days') }})</p>
                                    </div>
                                </div>
                                <div>
                                    <small>{{ __('front/shared/contract-summary.travelers') }}:</small> {{ $quotation->passenger_ammount }}
                                    <span style="font-size: 12px">({{ $quotation->ageEnum() }})</span>
                                </div>                         
                            </li>
                            <li>
                                <h5>{{ __('front/shared/contract-summary.insurance_details') }}</h5>
                                <small>{{ __('front/shared/contract-summary.provider') }}:</small>
                                <p>{{ $product->provider_name }}</p>
                                <small>{{ __('front/shared/contract-summary.product') }}:</small>
                                <p>{{ $product->product_name }}</p>
                                <small>{{ __('front/shared/contract-summary.coverage') }}:</small>
                                <ul class="list-unstyled coverage-details-list">
                                    @if (sizeof($product_coverage) > 10)
                                        @for ($i=0; $i<10; $i++)
                                            <li>{{ $product_coverage[$i]["description"] }}: <strong>{{ $product_coverage[$i]["ammount"] }}</strong></li>
                                        @endfor
                                        <a href="javascript:void(0);" onclick="$(this).hide();$('#coverage-collapse').show();">{{ __('front/shared/contract-summary.show_all') }}</a>
                                        <div id="coverage-collapse" style="display: none">
                                        @for ($i=10; $i<sizeof($product_coverage); $i++)
                                            <li>{{ $product_coverage[$i]["description"] }}: <strong>{{ $product_coverage[$i]["ammount"] }}</strong></li>
                                        @endfor
                                        </div>
                                    @else
                                        @foreach ($product_coverage as $coverage)
                                        <li>{{ $coverage["description"] }}: <strong>{{ $coverage["ammount"] }}</strong></li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="gap-small"></div>
                                <a href="{{ $product->terms_url }}" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp;{{ __('front/shared/contract-summary.terms_and_conditions') }}</a>
                            </li>
                        </ul>
                        <p class="booking-item-payment-total">{{ __('front/shared/contract-summary.total') }}: <span>{{ $product->price." ".$product->price_currency_code }}</span>
                        </p>
                    </div>