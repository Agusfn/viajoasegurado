@extends('mails.layout')


@section('content')

<p>Estimado {{ $fullname }}, hemos procesado la solicitud por la contratación <strong>#{{ $contract->number }}</strong> por el viaje a <strong>{{ \App\Library\AseguratuViaje\ATV::getRegionName($contract->quotation->destination_region_code) }}</strong> y tu voucher ha sido enviado a esta dirección de correo electrónico por medio de nuestro operador <strong>aseguratuviaje.com</strong>.</p>
<p>En dicho mensaje encontrarás <strong>el voucher, las prestaciones del seguro, los números de teléfono útiles</strong>, y toda la información necesaria para viajar asegurado/a.</p>
<p>El mensaje debería tomar unos minutos en llegar, y como máximo una hora. Si no lo encuentras revisa tu casilla de correo no deseado o <a href="mailto:{{ __('front\support.contact_email') }}">contactanos</a>.</p>
<p>Gracias por elegirnos!<br/>
El equipo de Viajoasegurado.com</p>

@endsection