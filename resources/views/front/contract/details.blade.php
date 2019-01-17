@extends('front.layouts.main')        

@section('title', __('front/contract_details.title'))


@section('meta-tags')
    <meta name="robots" content="noindex, nofollow"> 
@endsection


@section('content')
    
        <div class="gap"></div>

        @if ($contract_found == true)

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    @if ($contract->current_status_id == \App\Contract::STATUS_PAYMENT_PENDING)

                        @if ($paymentReq->status == \App\PaymentRequest::STATUS_UNPAID)
                            <i class="fa fa-clock-o round box-icon-large box-icon-center box-icon-gray mb30"></i>  
                            <h2 class="text-center">{{ __('front/contract_details.payment_pending') }}</h2>
                            <h5 class="text-center mb30">{{ __('front/contract_details.payment_pending_details') }} <a href="{{ $paymentReq->payment_url }}">{{ __('here') }}</a>.</h5>
                        @elseif ($paymentReq->status == \App\PaymentRequest::STATUS_PROCESSING)
                            <i class="fa fa-clock-o round box-icon-large box-icon-center box-icon-gray mb30"></i>  
                            <h2 class="text-center">{{ __('front/contract_details.payment_processing') }}</h2>
                            <h5 class="text-center mb30">
                                {{ __('front/contract_details.payment_processing_details') }}<br/>{{ __('front/contract_details.payment_processing_details2') }}
                            </h5>
                        @endif

                    @elseif ($contract->current_status_id == \App\Contract::STATUS_PROCESSING || $contract->current_status_id == \App\Contract::STATUS_COMPLETED)

                        <i class="fa fa-check round box-icon-large box-icon-center box-icon-success mb30"></i>  
                        <h2 class="text-center">{{ __('front/contract_details.payment_completed') }}</h2>

                        @if ($contract->current_status_id == \App\Contract::STATUS_PROCESSING)
                            <h5 class="text-center mb30"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ __('front/contract_details.payment_completed_details') }}<br/> {{ __('front/contract_details.payment_completed_details2') }}</h5>
                        @elseif ($contract->current_status_id == \App\Contract::STATUS_COMPLETED)
                            <h5 class="text-center mb30">{{ __('front/contract_details.voucher_sent_to') }} {{ $contract->contact_email }}.</h5>
                        @endif

                    @elseif ($contract->current_status_id == \App\Contract::STATUS_CANCELED_UNPAID)

                    @elseif ($contract->current_status_id == \App\Contract::STATUS_CANCELED_ERROR_PAYMENT)

                        <i class="fa fa-times round box-icon-large box-icon-center box-icon-success mb30"></i>  
                        <h2 class="text-center">{{ __('front/contract_details.payment_failed') }}</h2>
                        <h5 class="text-center mb30">{{ __('front/contract_details.payment_failed_details') }}</h5>

                    @elseif ($contract->current_status_id == \App\Contract::STATUS_CANCELED_OTHER)

                    @endif


               
                </div>
                
            </div>
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    @include('front.layouts.contract-summary')
                </div>
            </div>
            <div class="gap"></div>
        </div>

        @else

        <h3 style="text-align: center">{{ __('front/contract_details.contract_not_found') }}</h3>

        @endif
        
        
@endsection


@section('custom-js')
@endsection