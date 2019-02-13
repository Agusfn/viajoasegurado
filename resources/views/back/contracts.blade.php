@extends('back.layouts.main')

@section('title', 'Contrataciones')

@php ($section = 'contracts')


@section('content')
			
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Contrataciones</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
									<tr>
										<th></th>
										<th>Fecha</th>
										<th>Número</th>
										<th>Producto</th>
										<th>Fechas</th>
										<th>País desde</th>
										<th>Región hacia</th>
										<th>Pasajeros</th>
										<th>Pago</th>
										<th>Estado</th>
										<th>Precio final</th>
										<th>Medio de pago</th>
									</tr>
								</thead>
								<tbody>
		                            @foreach($contracts as $contract)

		                            	<tr>
		                            		<td>
		                            			<a href="{{ url('contracts/'.$contract->id) }}" class="btn btn-primary btn-sm">Ver</a>
		                            			@if ($contract->current_status_id == \App\Contract::STATUS_PROCESSING)
		                            			&nbsp;&nbsp;<i class="fa fa-exclamation-circle" style="font-size: 19px; color: #F48024" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Esperando envío de voucher"></i>
		                            			@endif		                            		
		                            		</td>
		                            		<td>
		                            			{{ date("d/m/Y", strtotime($contract->created_at)) }}</td>
		                            		<td>#{{ $contract->number }}</td>
		                            		<td>{{ $contract->product->product_name }}<br/><span style="color:#999;font-size: 13px">{{ $contract->product->provider_name }}</span></td>
		                            		<td>
		                            			{{ \App\Library\Dates::translate($contract->quotation->date_from) }}-<br/>{{ \App\Library\Dates::translate($contract->quotation->date_to) }}
		                            			<small>({{ \App\Library\Dates::diffDays($contract->quotation->date_from, $contract->quotation->date_to) }} días)</small>
		                            		</td>
		                            		<td>{{ __($contract->quotation->country_from->name_english) }}</td>
		                            		<td>{{ \App\Library\AseguratuViaje\ATV::getRegionName($contract->quotation->destination_region_code) }}</td>
		                            		<td>{{ $contract->quotation->passenger_ammount }}</td>
		                            		<td>
												@if ($contract->active_payment_request != null)
													@if ($contract->active_payment_request->status == \App\PaymentRequest::STATUS_UNPAID)
													<span class="label label-default">Pendiente</span> 
													@elseif ($contract->active_payment_request->status == \App\PaymentRequest::STATUS_PROCESSING)
													<span class="label label-warning">Procesando</span> 
													@elseif ($contract->active_payment_request->status == \App\PaymentRequest::STATUS_APPROVED)
													<span class="label label-success">Completado</span> 
													@elseif ($contract->active_payment_request->status == \App\PaymentRequest::STATUS_FAILED)
													<span class="label label-danger">Fallido</span>
													@elseif ($contract->active_payment_request->status == \App\PaymentRequest::STATUS_REFUNDED)
													<span class="label label-danger">Reembolsado</span> 
													@elseif ($contract->active_payment_request->status == \App\PaymentRequest::STATUS_EXPIRED)
													<span class="label label-danger">Expiró</span> 
													@endif
												@endif
		                            		</td>
		                            		<td>
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
		                            		</td>
		                            		<td>{{ $contract->product->price." ".$contract->product->price_currency_code }}</td>
		                            		<td>
		                            			@if ($contract->active_payment_request != null)
		                            			{{ $contract->active_payment_request->payment_method->name }}
		                            			@else
		                            			-
		                            			@endif
		                            		</td>
		                            	</tr>

		                            @endforeach
								</tbody>
							</table>
							{{ $contracts->links() }}
						</div>
					</div>



@endsection

@section('custom-js')

@endsection