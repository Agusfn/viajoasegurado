@extends('back.layouts.main')

@section('title', 'Cotizaciones')

@php ($section = 'quotations')


		
@section('content')
			
					<h3 class="page-title">Cotizaciones</h3>
					<div class="panel">
						<div class="panel-heading">
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
									<tr>
										<th></th>
										<th>Fecha</th>
			                            <th>País origen</th>
			                            <th>Región destino</th>
			                            <th>Fechas</th>
			                            <th>Pasajeros</th>
			                            <th>Edades</th>
			                            <th>Email</th>
			                            <th>Productos<br/>cotizados</th>
			                            <th>Contrató</th>
									</tr>
								</thead>
								<tbody>
		                            @foreach($quotations as $quotation)
		                            <tr data-href="{{ url('quotations/'.$quotation->id) }}" class="clickable-row">
		                            	<td><a href="{{ URL::to('quotations/'.$quotation->id) }}" class="btn btn-primary btn-sm">Ver</a></td>
		                            	<td>{{ date("d/m/Y", strtotime($quotation->created_at)) }}</td>
		                                <td>{{ __($quotation->country_from->name_english) }}</td>
		                                <td>{{ \App\Library\AseguratuViaje\ATV::getRegionName($quotation->destination_region_code) }}</td>
		                                <td>{{ date('d/m/Y',strtotime($quotation->date_from)) }}<br/> {{ date('d/m/Y',strtotime($quotation->date_to)) }}</td>
		                                <td>
		                                	{{ $quotation->passenger_ammount }} 
		                                	@if ($quotation->gestation_weeks > 0)
	                                		&nbsp;<span class="label label-default">Embarazada</span>
		                                	@endif
		                                </td>
		                                <td>{{ $quotation->passenger_ages }}</td>
		                                <td>{{ $quotation->customer_email }}</td>
		                                <td>{{ $quotation->products()->count() }}</td>
		                                <td>
		                                	@if ($quotation->contract == null)
		                                	<span class="label label-danger">No</span>
		                                	@else
		                                		@if ($quotation->contract->current_status_id == App\Contract::STATUS_PAYMENT_PENDING)
		                                		<span class="label label-warning">Pago pendiente</span>
		                                		@else
		                                		<span class="label label-success">Si</span>
		                                		@endif
		                                	@endif
		                                </td>
		                            </tr>
		                            @endforeach
								</tbody>
							</table>
						</div>
					</div>

@endsection