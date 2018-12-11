@extends('frontoffice.layouts.main')

@section('content')

<h3>Formulario de contratación de seguro</h3>

<br/>
<h3><strong>Datos del seguro</strong></h3>

Región destino: {{ $quotation->destination_region_code }}<br/>
Fecha desde: {{ $quotation->date_from }}<br/>
Fecha hasta: {{ $quotation->date_to }}<br/>
Proveedor: {{ $quotation_product->provider }}<br/>
Producto: {{ $quotation_product->product_name }}<br/>
<br/>
<strong>Detalles cobertura</strong><br/>

@foreach($product_coverage as $item)

{{ $item["description"].": ".$item["ammount"] }}<br/>

@endforeach

<br/>
<a href="{{ $quotation_product->terms_url }}">Términos y condiciones</a><br/>
<br/>
<br/>
<strong>Datos del titular</strong>
<br/>
{{ Form::open( array("url" => "contract", "method" => "post") ) }}
	<input type="hidden" name="quotation_code" value="{{ $quotation->url_code }}">
	<input type="hidden" name="quotationproduct_atvid" value="{{ $quotation_product->product_atv_id }}">
	Nombre:
	<input type="text" name="nombre_titular"><br/>

	Apellido:
	<input type="text" name="apellido_titular"><br/>

	Email:
	<input type="text" name="email_titular"><br/>

	<br/><br/>
	<h3><strong>Total:</strong> {{ $quotation_product->price." ".$quotation_product->price_currency_code }}<br/></h3>

	Medio de pago:<br/>
	
	@if($quotation_product->price_currency_code == "ARS")
	<h4>Mercadopago</h4>
	@elseif ($quotation_product->price_currency_code == "USD")
	<h4>PayPal</h4>
	@else
	<h4>No hay medios de pago disponibles</h4>
	@endif

	(los demas datos los agregamos despues)<br/><br/>

	<input type="submit" value="Enviar" />
{{ Form::close() }}


@endsection
