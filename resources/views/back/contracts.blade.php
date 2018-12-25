@extends('back.layouts.main')

@section('title', 'Contrataciones')

@php ($section = 'contracts')


@section('content')
			

					<h3 class="page-title">Contrataciones</h3>
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Contrataciones</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
									<tr>
										<th></th>
										<th>Número</th>
										<th>Producto</th>
										<th>Fechas</th>
										<th>País desde</th>
										<th>Región hacia</th>
										<th>Pasajeros</th>
										<th>Estado</th>
										<th>Precio final</th>
										<th>Medio de pago</th>
										<th>Fecha</th>
									</tr>
								</thead>
								<tbody>
		                            @foreach($contracts as $contract)

		                            	<tr>
		                            		<td><a href="{{ url('contracts/'.$contract->id) }}" class="btn btn-primary btn-sm">Ver</a></td>
		                            		<td>{{ $contract->number }}</td>
		                            		<td>{{ $contract->product->product_name }} - <span style="color:#999;font-size: 13px">{{ $contract->product->provider_name }}</span></td>
		                            		<td>
		                            			{{ date("d/m/Y", strtotime($contract->quotation->date_from)) }} a <br/>{{ date("d/m/Y", strtotime($contract->quotation->date_to)) }}
		                            			({{ (new DateTime($contract->quotation->date_to))->diff(new DateTime($contract->quotation->date_from))->format("%a") }} días)
		                            		</td>
		                            		<td>{{ __($contract->quotation->country_from->name_english) }}</td>
		                            		<td>{{ \App\Library\AseguratuViaje\ATV::getRegionName($contract->quotation->destination_region_code) }}</td>
		                            		<td>{{ $contract->quotation->passenger_ammount }}</td>
		                            		<td>
		                            			<span class="label" style="background-color: {{ $contract->status->color }};">{{ __($contract->status->name_english) }}</span>
		                            		</td>
		                            		<td>{{ $contract->active_payment_request->total_ammount." ".$contract->active_payment_request->currency_code }}</td>
		                            		<td>{{ $contract->active_payment_request->payment_method->name }}</td>
		                            		<td>{{ date("d/m/Y", strtotime($contract->created_at)) }}</td>
		                            	</tr>

		                            @endforeach
								</tbody>
							</table>
						</div>
					</div>



@endsection