@extends('back.layouts.main')

@section('title', 'Contrataciones')

@php ($section = 'contracts')


@section('custom-css')
<style>
#voucher-sent-form {
	display: inline-block;
}
</style>
@endsection

		
@section('content')
					
					<p><a href="{{ url('contracts') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver a contrataciones</a></p>
					

					@if ($contract != null)					

					<h3 class="page-title">Contratación nro. #{{ $contract->number }} (ID: {{ $contract->id }})</h3>
					
					<div class="row">
						
						<div class="col-lg-6">

							<div class="panel">

								<div class="panel-heading">
									<h3 class="panel-title">Detalles de la contratación&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado:&nbsp;&nbsp;&nbsp;
                            			@if ($contract->current_status_id == \App\Contract::STATUS_PAYMENT_PENDING)
                            			<span class="label label-warning">Pendiente de pago</span> 
                            			@elseif ($contract->current_status_id == \App\Contract::STATUS_PROCESSING)
                            			<span class="label label-primary">Esperando póliza</span>
                            			@elseif ($contract->current_status_id == \App\Contract::STATUS_COMPLETED)
                            			<span class="label label-success">Completado</span>
                            			@elseif ($contract->current_status_id == \App\Contract::STATUS_CANCELED_UNPAID)
                            			<span class="label label-danger">Cancelado - Impago</span>
                            			@elseif ($contract->current_status_id == \App\Contract::STATUS_CANCELED_ERROR_PAYMENT)
                            			<span class="label label-danger">Cancelado - Error pago</span>
                            			@elseif ($contract->current_status_id == \App\Contract::STATUS_CANCELED_OTHER)
                            			<span class="label label-danger">Cancelado - Otro</span>
                            			@endif
									</h3>
								</div>

								<div class="panel-body">
									
									@if ($contract->current_status_id != \App\Contract::STATUS_COMPLETED)
									<div class="well well-sm">

										@if ($contract->current_status_id != \App\Contract::STATUS_COMPLETED)
											{{ Form::open(['method' => 'post', 'url' => url('contracts/'.$contract->id.'/complete'), 'id' => 'voucher-sent-form']) }}
												<input type="button" class="btn btn-primary btn-sm" id="voucher-sent-btn" value="Voucher enviado">&nbsp;&nbsp;
											{{ Form::close() }}
										@endif

										@if ($contract->current_status_id == \App\Contract::STATUS_PAYMENT_PENDING)
											@if ($contract->active_payment_request != null && $contract->active_payment_request->status == \App\PaymentRequest::STATUS_UNPAID)
											<!--button class="btn btn-danger btn-sm">Cancelar solicitud</button>&nbsp;&nbsp;-->
											@endif

										@elseif($contract->current_status_id == \App\Contract::STATUS_PROCESSING)

											@if ($contract->active_payment_request != null && $contract->active_payment_request->status == \App\PaymentRequest::STATUS_APPROVED)
											<!--button class="btn btn-danger btn-sm">Cancelar y reembolsar</button-->&nbsp;&nbsp;
											@endif

										@endif

									</div>
									@endif



									<h4 style="text-align: center;">Historial de estados</h4>

									<table class="table">
										<tbody>

											@foreach ($contract->status_history as $statusChange)

											<tr>
												@if ($statusChange->status_id == \App\Contract::STATUS_PAYMENT_PENDING)
												<td>Creación de solicitud</td>
												@elseif ($statusChange->status_id == \App\Contract::STATUS_PROCESSING)
												<td>Pago realizado</td>
												@elseif ($statusChange->status_id == \App\Contract::STATUS_COMPLETED)
												<td>Envío de datos de póliza de seguro</td>
												@elseif ($statusChange->status_id == \App\Contract::STATUS_CANCELED_UNPAID)
												<td>Cancelado por pago no realizado a tiempo</td>
												@elseif ($statusChange->status_id == \App\Contract::STATUS_CANCELED_ERROR_PAYMENT)
												<td>Cancelado por error en el pago</td>
												@elseif ($statusChange->status_id == \App\Contract::STATUS_CANCELED_OTHER)
												<td>Cancelado</td>
												@endif
												<td>{{ date("d/m/Y H:i:s", strtotime($statusChange->created_at)) }}</td>
											</tr>

											@endforeach
											
										</tbody>
									</table>

								</div>
							</div>



							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del producto</h3>
								</div>
								<div class="panel-body">
								
									<div class="row">
										<div class="col-xs-3">
											<dt>Cotización</dt>
											<p><a href="{{ url('quotations/'.$contract->quotation_id) }}">#{{ $contract->quotation_id }}</a></p>
										</div>
										<div class="col-xs-3">
											<dt>Producto</dt>
											<p>{{ $contract->product->product_name }}</p>
										</div>
										<div class="col-xs-2">
											<dt>ID ATV</dt>
											<p>{{ $contract->product->product_atv_id }}</p>
										</div>										
										<div class="col-xs-4">
											<dt>Proveedor</dt>
											<p>{{ $contract->product->provider_name }}</p>
										</div>
									</div>

									<div class="row" style="margin-top: 20px">
										<div class="col-xs-3">
											<dt>Costo</dt>
											<p>{{ $contract->product->cost." ".$contract->product->cost_currency_code }}</p>
										</div>
										<div class="col-xs-3">
											<dt>Precio de venta</dt>
											<p>{{ $contract->product->price." ".$contract->product->price_currency_code }}</p>
										</div>
										<div class="col-xs-3">
											<p><a href="{{ $contract->product->terms_url }}" target="_blank" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-file"></span> Ver condiciones</a></p>
										</div>
										<div class="col-xs-3">
											<p><a href="javascript:void(0);" class="btn btn-sm btn-info" id="show-coverage-btn" data-coverage-json='{{ $contract->product->coverage_details_json }}'><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;Ver cobertura</a></p>
										</div>
									</div>



								</div>
							</div>

							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del pago</h3>
								</div>
								<div class="panel-body">
									
									@if ($contract->active_payment_request != null)
										@if ($contract->active_payment_request->status == \App\PaymentRequest::STATUS_PROCESSING)
										<div class="alert alert-warning"><span class="glyphicon glyphicon-time"></span> {{ $contract->active_payment_request->payment_method->name }} se encuentra procesando el pago y pronto se actualizará automáticamente el estado del mismo.</div>
										@elseif ($contract->active_payment_request->status == \App\PaymentRequest::STATUS_APPROVED)
										<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> El pago se realizó correctamente.</div>
										@elseif ($contract->active_payment_request->status == \App\PaymentRequest::STATUS_FAILED)
										<div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span> El pago falló y no se pudo concretar.</div>
										@endif
									@endif
									

									<table class="table">
										<thead>
											<tr>
												<th>Medio de pago</th>
												<th>Total</th>
												<th>Tarifa</th>
												<th>Neto</th>
												<th>Estado del pago</th>
												<th>Fecha de pago</th>
											</tr>
										</thead>

										<tbody>
											@foreach ($contract->payment_requests() as $paymentRequest)
											<tr>
												<td>{{ $paymentRequest->payment_method->name }}</td>
												<td>{{ $paymentRequest->total_ammount." ".$paymentRequest->currency_code }}</td>
												<td>
													@if ($paymentRequest->status == \App\PaymentRequest::STATUS_APPROVED)
													{{ $paymentRequest->transaction_fee." ".$paymentRequest->currency_code }}
													@endif
												</td>
												<td>
													@if ($paymentRequest->status == \App\PaymentRequest::STATUS_APPROVED)
													{{ $paymentRequest->net_ammount." ".$paymentRequest->currency_code }}
													@endif
												</td>
												<td>
													@if ($paymentRequest->status == \App\PaymentRequest::STATUS_UNPAID)
														<span class="label label-default">Pendiente</span>
													@elseif ($paymentRequest->status == \App\PaymentRequest::STATUS_PROCESSING)
														<span class="label label-warning">Procesando</span>
													@elseif ($paymentRequest->status == \App\PaymentRequest::STATUS_APPROVED)
														<span class="label label-success">Completado</span>
													@elseif ($paymentRequest->status == \App\PaymentRequest::STATUS_FAILED)
														<span class="label label-danger">Falló</span>
													@elseif ($paymentRequest->status == \App\PaymentRequest::STATUS_REFUNDED)
														<span class="label label-danger">Reembolsado</span>
													@elseif ($paymentRequest->status == \App\PaymentRequest::STATUS_EXPIRED)
														<span class="label label-danger">Expiró</span>
													@endif
												</td>
												<td>
													@if ($paymentRequest->status == \App\PaymentRequest::STATUS_APPROVED)
													{{ date("d/m/Y H:i:s", strtotime($paymentRequest->date_paid)) }}
													@else
													-
													@endif
												</td>
											</tr>
											@endforeach
										</tbody>

									</table>

									<div class="row" style="margin-top: 40px">
										<div class="col-xs-3">
											<dt>Cobrado</dt>
											<p>{{ $contract->product->price." ".$contract->product->price_currency_code }}</p>
										</div>
										<div class="col-xs-3">
											<dt>Neto recibido</dt>
											@if ($contract->active_payment_request != null && $contract->active_payment_request->status == \App\PaymentRequest::STATUS_APPROVED)
											<p>{{ $contract->active_payment_request->net_ammount." ".$contract->active_payment_request->currency_code }}</p>
											@else
											-
											@endif
										</div>
										<div class="col-xs-3">
											<dt>Costo producto</dt>
											<p>{{ $contract->product->cost." ".$contract->product->cost_currency_code }}</p>
										</div>										
										<div class="col-xs-3">
											<dt>Ganancia</dt>
											@if ($contract->active_payment_request != null && $contract->active_payment_request->status == \App\PaymentRequest::STATUS_APPROVED && $contract->product->cost_currency_code == $contract->product->price_currency_code)

											<p>{{ ($contract->active_payment_request->net_ammount-$contract->product->cost)." ".$contract->product->cost_currency_code }}</p>

											@else
											-
											@endif											
										</div>									
									</div>									
								</div>
							</div>	

							

						</div>

						<div class="col-lg-6">

							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del viaje</h3>
								</div>
								<div class="panel-body">
									
									<div class="row" style="margin-bottom: 20px">
										<div class="col-sm-3">
											<dt>País desde</dt>
											<p>{{ __($contract->quotation->country_from->name_english) }}</p>
										</div>
										<div class="col-sm-3">
											<dt>Región hacia</dt>
											<p>{{ \App\Library\AseguratuViaje\ATV::getRegionName($contract->quotation->destination_region_code) }}</p>
										</div>
										<div class="col-sm-3">
											<dt>Fecha desde</dt>
											<p>{{ date("d/m/Y", strtotime($contract->quotation->date_from)) }}</p>
										</div>
										<div class="col-sm-3">
											<dt>Fecha hasta</dt>
											<p>
												{{ date("d/m/Y", strtotime($contract->quotation->date_to)) }}
												({{ \App\Library\Dates::diffDays($contract->quotation->date_to, $contract->quotation->date_from) }} días)
											</p>
										</div>
									</div>


									@php ($passengers = $contract->getPassengerDetails())
									<h4 style="text-align: center; margin-bottom: 10px">Pasajeros ({{ sizeof($passengers) }})</h4>

									<table class="table table-condensed">
										<thead>
											<thead>
												<tr>
													<th>Nombre</th>
													<th>Apellido</th>
													<th>Documento</th>
													<th>Fecha nac.</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($passengers as $passenger)
												<tr>
													<td>{{ $passenger["name"] }}</td>
													<td>{{ $passenger["surname"] }}</td>
													<td>{{ $passenger["identification"] }}</td>
													<td>{{ date("d/m/Y", strtotime($passenger["date_birth"])) }} ({{ $passenger["age"] }} años)</td>
												</tr>
												@endforeach
											</tbody>
										</thead>
									</table>
		
								</div>

							</div>

							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Datos de contacto y facturación</h3>
								</div>
								<div class="panel-body">
									
									<div class="row" style="margin-bottom: 20px">
										<div class="col-sm-6">
											<h4 style="margin-top: 0">Contacto</h4>
											<dt>E-mail</dt>
											<p>{{ $contract->contact_email }}</p>
											<dt>Teléfono</dt>
											<p>{{ $contract->contact_phone }}</p>
										</div>

										<div class="col-sm-6">
											<h4 style="margin-top: 0">Contacto emergencias</h4>
											<dt>Nombre</dt>
											<p>{{ $contract->emergency_contact_fullname }}</p>
											<dt>Teléfono</dt>
											<p>{{ $contract->emergency_contact_phone }}</p>
										</div>
									</div>




									<h4 style="text-align: center; margin-bottom: 20px">Datos de facturación</h4>

									@if ($contract->quotation->origin_country_code == 32)

										<div class="row">

											<div class="col-md-6">
												<dt>Condición fiscal</dt>
												<p>
													@if ($contract->billing_fiscal_condition == "consumidor-final")
													Consumidor final
													@elseif ($contract->billing_fiscal_condition == "responsable-inscripto")
													Responsable inscripto
													@elseif ($contract->billing_fiscal_condition == "monotributista")
													Monotributo
													@elseif ($contract->billing_fiscal_condition == "iva-exento")
													IVA exento
													@endif
												</p>
												<dt>Nombre / Razón social</dt>
												<p>{{ $contract->billing_fullname }}</p>
												<dt>CUIL/CUIT</dt>
												<p>{{ $contract->billing_tax_number }}</p>
											</div>

											<div class="col-md-6">
												<label>Dirección</label>
												<div class="well">
													{{ $contract->billing_fullname }}<br/>
													{{ $contract->billing_address_street." ".$contract->billing_address_number.", ".$contract->billing_address_appt }}<br/>
													{{ $contract->billing_address_city }}, {{ $contract->billing_address_state }}, {{ $contract->billing_address_zip }}<br/>
													{{ $contract->billing_address_country }}
												</div>
											</div>

										</div>
									@else
										<div style="text-align: center;">-</div>
									@endif

								</div>

							</div>

							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Notas</h3>
								</div>
								<div class="panel-body">

									{{ Form::open( array("url" => url("contracts/".$contract->id."/note"), "method" => "post") ) }}

									<textarea class="form-control" name="notes" style="margin-bottom: 10px">{{ $contract->notes }}</textarea>
									<input type="submit" class="btn btn-primary" value="Guardar">

									{{ Form::close() }}
								</div>
							</div>


						</div>



					</div>

					

					@else
					<h3 class="page-title">Contratación</h3>
					<h3 style="text-align: center;">La contratación solicitada no existe</h3>
					@endif


				
@endsection


@section('custom-js')
<script>
$(document).ready(function() {

	$("#show-coverage-btn").click(function() {
		var coverage_details = JSON.parse($(this).attr("data-coverage-json"));
    	var list = "";
    	coverage_details.forEach(function(elem) {
    		list += elem.description + ": " + elem.ammount + "\n";
    	});	

    	alert(list);
	});

	$("#voucher-sent-btn").click(function() {
		if(confirm("¿Completar contratación y marcar voucher como enviado?"))
			$("#voucher-sent-form").submit();
	});

});
</script>
@endsection