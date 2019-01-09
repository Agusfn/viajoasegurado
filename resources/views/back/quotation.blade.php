@extends('back.layouts.main')

@section('title', 'Cotizaciones')

@php ($section = 'quotations')


		
@section('content')
					
					<p><a href="{{ url('quotations') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver a cotizaciones</a></p>
					
					@if ($quotation != null)

					<h3 class="page-title">Cotización #{{ $quotation->id }}</h3>
					
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Detalles de la cotización</h3>
						</div>
						<div class="panel-body">
							
							<div class="row" style="font-size: 16px">

								<div class="col-md-1">
									<label>ID:</label> {{ $quotation->id }}
								</div>
								<div class="col-md-3">
									<label>Fecha creada:</label><br/>
									{{ date("d/m/Y H:i:s", strtotime($quotation->created_at)) }}
								</div>
								<div class="col-md-3">
									<label>Expira:</label><br/>
									{{ date("d/m/Y H:i:s", strtotime($quotation->expiration_date)) }}
									@if (time() > strtotime($quotation->expiration_date))
										<span class="label label-default">Expiró</span>
									@endif
								</div>

								<div class="col-md-2">
									<label>E-mail interesado:</label><br/>
									{{ $quotation->customer_email }}
								</div>
								<div class="col-md-2">
									<label>Contratado:</label><br/>
									@if ($quotation->contract_id == null)
										<span class="label label-danger">No</span>
									@else
	                            		<a href="{{ url('contracts/'.$quotation->contract_id) }}">#{{ $quotation->contract->number }}</a>
									@endif
								</div>
								<div class="col-md-1">
									<label>Lenguaje:</label><br/>
									{{ $quotation->lang }}
								</div>
							</div>

						</div>

					</div>


					<div class="row">

						<div class="col-md-6">

							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles viaje</h3>
								</div>
								<div class="panel-body">
										
									<div class="row" style="margin-bottom:30px">

										<div class="col-md-5">
											<label>País desde:</label><br/>
											{{ __($quotation->country_from->name_english) }}
										</div>
										<div class="col-md-5">
											<label>Región hacia:</label><br/>
											{{ \App\Library\AseguratuViaje\ATV::getRegionName($quotation->destination_region_code) }}
										</div>
										<div class="col-md-2">
											<label>Tipo de viaje:</label><br/>
											{{ $quotation->trip_type_code }}
										</div>
									</div>


									<div class="row">
										<div class="col-md-6">
											<label>Fecha desde:</label><br/>
											{{ date("d/m/Y", strtotime($quotation->date_from)) }}
										</div>
										<div class="col-md-6">
											<label>Fecha hasta:</label><br/>
											{{ date("d/m/Y", strtotime($quotation->date_to)) }}
											({{ (new DateTime($quotation->date_to))->diff(new DateTime($quotation->date_from))->format("%a") }} días)
										</div>

									</div>

								</div>

							</div>

						</div>

						<div class="col-md-6">
						
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Pasajeros</h3>
								</div>
								<div class="panel-body">
									
									<label>Cantidad de pasajeros:</label> {{ $quotation->passenger_ammount }}
                                	@if ($quotation->gestation_weeks > 0)
                            		&nbsp;<span class="label label-default">Embarazada</span>
                                	@endif
									<br/>
									<label>Edades:</label>
									<?php
										$ages = explode(",", $quotation->passenger_ages);
										foreach($ages as $age) {
											echo "<span class='label label-primary' style='font-size:14px'>".$age."</span>&nbsp;";
										}
									?>

								</div>

							</div>

						</div>

					</div>




					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Productos cotizados</h3>
						</div>
						<div class="panel-body">

							@if ($quotation->quoted)

								@if ($quotation->products->count() > 0)

		                        <table class="table">

		                            <thead>
		                            	<tr>
			                                <th>Proveedor</th>
			                                <th>Producto</th>
			                                <th>ID ATV</th>
			                                <th>Cobertura</th>
			                                <th>Costo</th>
			                                <th>Comisión</th>
			                                <th>Precio</th>
			                            </tr>
		                            </thead>

		                            <tbody>
		                                @foreach ($quotation->products as $product)
		                                <tr>
		                                    <td><img src="{{ $product->img_url }}" alt="{{ $product->provider_name }}" height="50" /></td>
		                                    <td>{{ $product->product_name }}</td>
		                                    <td>{{ $product->product_atv_id }}</td>
		                                    <td>
		                                    	@if ($product->coverage_details_json != null)
	                            					<a href="javascript:void(0);" data-coverage-details='{{ $product->coverage_details_json }}' class="coverage-details-link">Detalles cobertura</a>
		                                    	@else
													<a href="javascript:void(0);" onclick="alert('Enfermedad: {{ $product->disease_insured_amt }}\nAccidente: {{ $product->accident_insured_amt }}\nEquipaje: {{ $product->baggage_insured_amt }}')">Detalles cobertura</a>
		                                    	@endif
		                                    	<br/>
		                                    	<a href="{{ $product->terms_url }}" target="_blank">Condiciones</a>
		                                    </td>
		                                    <td>{{ $product->cost." ".$product->cost_currency_code }}</td>
		                                    <!-- Columna comisión sólo si el costo y precio son de la misma moneda -->
		                                    <td>
		                                    	{{ ($product->price-$product->cost)." ".$product->cost_currency_code }}
		                                    </td>
		                                    <td><strong>{{ $product->price." ".$product->price_currency_code }}</strong></td>
		                                </tr>
		                                @endforeach
		                            </tbody>

		                        </table>

								@else

								<h4 style="text-align: center;">No se encontraron productos disponibles para este viaje.</h4>

								@endif

							@else

							<h4 style="text-align: center;">No se cotizó este viaje aún.</h4>

							@endif


						</div>

					</div>


					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Detalles técnicos</h3>
						</div>
						<div class="panel-body">
							
							<div class="row">
								<div class="col-md-5">
									<label>Cód URL:</label><br/>
									<a href="" target="_blank">{{ $quotation->url_code }}</a>
								</div>
								<div class="col-md-5">
									<label>Token cotización ATV</label><br/>
									{{ $quotation->atv_token }}
								</div>
								<div class="col-md-2">
									<label>IP cliente:</label><br/>
									{{ $quotation->customer_ip }}
								</div>
							</div>

						</div>

					</div>

					@else
					<h3 class="page-title">Cotización</h3>
					<h3 style="text-align: center;">La cotización solicitada no existe</h3>

					@endif

					

@endsection


@section('custom-js')
	<script>
	$(document).ready(function() {

		$(".coverage-details-link").click(function() {

			var coverage_details = JSON.parse($(this).attr("data-coverage-details"));
        	var list = "";
        	coverage_details.forEach(function(elem) {
        		list += elem.description + ": " + elem.ammount + "\n";
        	});	

        	alert(list);
		});
		
	});
	</script>
@endsection