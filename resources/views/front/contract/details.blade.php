@extends('front.layouts.main')

@section('content')


@if ($contract_found)

<h3>Detalles contratación</h3>

[los detalles del producto, de los viajeros, y del pago...]
<br/><br/><br/>

	@if($contract->current_status_id == App\Contract::STATUS_PAID)

		<strong>Pago realizado</strong><br/>
		Recibirás tu póliza dentro de las X horas por e-mail.

	@elseif ($contract->current_status_id == App\Contract::STATUS_PAYMENT_PENDING)

		Para recibir tu póliza, completa el pago de tu seguro por {{ $paymentReq->payment_method->name }} por {{ $paymentReq->total_ammount." ".$paymentReq->currency_code }} <a href="{{ $paymentReq->payment_url }}">aquí</a>.

	@endif



@else

<h3>No se encontró la contratación.</h3>


@endif





@endsection
