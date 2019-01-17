@extends('front.layouts.main')        

@section('title', 'Error')


@section('meta-tags')
    <meta name="robots" content="noindex, nofollow"> 
@endsection


@section('content')
    <div class="gap"></div>
    @if ($error == "other")
    <h3 style="text-align: center;">{{ __('front/contract_error.error_with_quotation') }}</h3>
    <h5 style="text-align: center;"><a href="{{ url('') }}">{{ __('front/contract_error.request_new_quotation') }}</a></h5>
    @elseif ($error == "expired")
    <h3 style="text-align: center;">{{ __('front/contract_error.quotation_expired') }}</h3>
    <h5 style="text-align: center;"><a href="{{ url('') }}">{{ __('front/contract_error.request_new_quotation') }}</a></h5>
    @elseif ($error == "payment-request-error")
    <h3 style="text-align: center;">{{ __('front/contract_error.error_generating_payment') }}</h3>
    <h5 style="text-align: center;"><a href="javascript:history.back();">{{ __('front/contract_error.resend_form') }}</a></h5>
    @endif
    
@endsection
