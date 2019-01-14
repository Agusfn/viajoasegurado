@extends('front.layouts.main')        


@section('content')
    <div class="gap"></div>
    @if ($error == "other")
    <h3 style="text-align: center;">Ocurrió un error con la cotización</h3>
    @elseif ($error == "expired")
    <h3 style="text-align: center;">La cotización expiró o ya se contrató.</h3>
    @elseif ($error == "payment-request-error")
    <h3 style="text-align: center;">Ocurrió un error generando la solicitud de pago.</h3>
    @endif
    <h5 style="text-align: center;"><a href="{{ url('') }}">Solicita una nueva cotización</a></h5>
@endsection
