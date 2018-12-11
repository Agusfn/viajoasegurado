@extends('back.layouts.main2')

@section('title', 'Cotizaciones')

@php ($section = 'quotations')


		
@section('content')
			
					<h3 class="page-title">Cotizaciones</h3>
					<div class="panel">
						<div class="panel-heading"></div>
						<div class="panel-body">
							<table class="table table-hover">
								<thead>
									<tr>
										<th></th>
										<th>Fecha</th>
			                            <th>País origen</th>
			                            <th>Destino</th>
			                            <th>Fechas</th>
			                            <th>Cantidad pasaj.</th>
			                            <th>Edades</th>
			                            <th>Email</th>
			                            <th>Productos cotiz.</th>
			                            <th>Contrató</th>
									</tr>
								</thead>
								<tbody>
		                            @foreach($quotations as $quotation)
		                            <tr data-href="{{ url('quotations/'.$quotation->id) }}" class="clickable-row">
		                            	<td><a href="{{ URL::to('quotations/'.$quotation->id) }}" class="btn btn-primary">Ver</a></td>
		                            	<td>{{ $quotation->created_at }}</td>
		                                <td>{{ $quotation->origin_country_code }}</td>
		                                <td>{{ $quotation->destination_region_code }}</td>
		                                <td>{{ date('d/m/Y',strtotime($quotation->date_from)) }}-{{ date('d/m/Y',strtotime($quotation->date_to)) }}</td>
		                                <td>{{ $quotation->passenger_ammount }}</td>
		                                <td>{{ $quotation->passenger_ages }}</td>
		                                <td>{{ $quotation->customer_email }}</td>
		                                <td>{{ $quotation->products()->count() }}</td>
		                                <td></td>
		                            </tr>
		                            @endforeach
								</tbody>
							</table>
						</div>
					</div>

@endsection