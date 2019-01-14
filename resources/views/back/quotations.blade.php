@extends('back.layouts.main')

@section('title', 'Cotizaciones')

@php ($section = 'quotations')


		
@section('content')
			
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Cotizaciones</h3>
						</div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
									<tr>
										<th></th>
										<th>Fecha cotiz.</th>
			                            <th>País origen</th>
			                            <th>Región destino</th>
			                            <th>Fechas</th>
			                            <th>Pasajeros</th>
			                            <th>Email</th>
			                            <th>Productos<br/>cotizados</th>
			                            <th>Contrató</th>
									</tr>
								</thead>
								<tbody>
		                            @foreach($quotations as $quotation)
		                            <tr data-href="{{ url('quotations/'.$quotation->id) }}" class="clickable-row">
		                            	<td><a href="{{ URL::to('quotations/'.$quotation->id) }}" class="btn btn-primary btn-sm">Ver</a></td>
		                            	<td>
		                            		{{ date("d/m/Y", strtotime($quotation->created_at)) }}
		                            		@if($quotation->expired())
		                            		<span class="label label-default">Expiró</span>
		                            		@endif
		                            	</td>
		                                <td>{{ __($quotation->country_from->name_english) }}</td>
		                                <td>{{ \App\Library\AseguratuViaje\ATV::getRegionName($quotation->destination_region_code) }}</td>
		                                <td>
		                                	{{ \App\Library\Dates::translate($quotation->date_from) }}-<br/>
		                                	{{ \App\Library\Dates::translate($quotation->date_to) }} <small>({{ \App\Library\Dates::diffDays($quotation->date_from, $quotation->date_to) }} días)</small></td>
		                                <td>{{ $quotation->passenger_ammount }}</td>
		                                <td>{{ $quotation->customer_email }}</td>
		                                <td>{{ $quotation->products()->count() }}</td>
		                                <td>
		                                	@if ($quotation->contract_id == null)
		                                	<small style="color:#888">N/A</small>
		                                	@else
		                                		<a href="{{ url('contracts'.'/'.$quotation->contract_id) }}">#{{ $quotation->contract->number }}</a>
		                                	@endif
		                                </td>
		                            </tr>
		                            @endforeach
								</tbody>
							</table>
							{{ $quotations->links() }}
						</div>
					</div>

@endsection