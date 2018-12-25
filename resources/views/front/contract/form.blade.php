@extends('front.layouts.main')

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
<h4>Formulario</h4>
<br/>
{{ Form::open( array("url" => "contract", "method" => "post") ) }}
	
	<input type="hidden" name="quotation_code" value="{{ $quotation->url_code }}">
	<input type="hidden" name="quotationproduct_atvid" value="{{ $quotation_product->product_atv_id }}">
	

	@for ($i=1; $i<=$quotation->passenger_ammount; $i++)

	<div>
		<h5>Pasajero {{ $i }}</h5>
		Nombre: <input type="text" name="passg{{ $i }}_name"> 
		Apellido: <input type="text" name="passg{{ $i }}_surname">
		Documento: <input type="text" name="passg{{ $i }}_document">
		Fecha nac: <input type="text" name="passg{{ $i }}_birthdate">
	</div>

	@endfor
	<br/><br/><br/>
	<div>
		<h5>Datos de contacto</h5>
		Telefono: <input type="text" name="contact_phone">
		Email: <input type="text" name="contact_email">
	</div>
	<br/>

	<div>
		<h5>Datos de contacto de emergencia</h5>
		Nombre: <input type="text" name="emerg_contact_name">
		Teléfono: <input type="text" name="emerg_contact_phone">
	</div><br/><br/>



	<div>
		<h5>Datos de facturación</h5>

		Condición fiscal<br/>
		<select name="billing_fiscal_condition">
			<option value="consumidor-final">Consumidor final</option>
			<option value="monotributista">Monotributo</option>
			<option value="iva-exento">IVA exento</option>
			<option value="responsable-inscripto">Resp. inscripto</option>
		</select><br/>

		Nombre / razón social:<br/>
		<input type="text" name="billing_fullname"><br/>

		CUIL/CUIT:<br/>
		<input type="text" name="billing_tax_number"><br/>

		Calle:<br/>
		<input type="text" name="billing_address_street"><br/>

		Altura:<br/>
		<input type="text" name="billing_address_number"><br/>

		Piso y depto / lote / UF:<br/>
		<input type="text" name="billing_address_appt"><br/>

		Localidad:<br/>
		<input type="text" name="billing_address_city"><br/>

		Provincia:<br/>
		<input type="text" name="billing_address_state"><br/>

		Código postal:<br/>
		<input type="text" name="billing_address_zip"><br/>

		<input type="hidden" name="billing_address_country" value="Argentina">

	</div>

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
