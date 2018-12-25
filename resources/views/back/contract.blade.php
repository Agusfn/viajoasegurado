@extends('back.layouts.main')

@section('title', 'Contrataciones')

@php ($section = 'contracts')


		
@section('content')
					
					<p><a href="{{ url('contracts') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver a contrataciones</a></p>
					

					@if ($contract != null)					

					<h3 class="page-title">Contratación #{{ $contract->id }}</h3>
					
					<div class="row">
						
						<div class="col-lg-6">

							<div class="panel">

								<div class="panel-heading">
									<h3 class="panel-title">Detalles de la contratación</h3>
								</div>

								<div class="panel-body">
									
									<div class="well well-sm">
										<button class="btn btn-primary btn-sm">Botón 1</button>&nbsp;&nbsp;
										<button class="btn btn-primary btn-sm">Botón 2</button>&nbsp;&nbsp;
										<button class="btn btn-primary btn-sm">Botón 3</button>&nbsp;&nbsp;
										<button class="btn btn-primary btn-sm">Botón 4</button>&nbsp;&nbsp;
									</div>

									<h4 style="text-align: center;">Estado</h4>

									<table class="table">
										<tbody>

											@foreach ($contract->status_history as $status_change)
											<tr {{ $status_change->status_id == $contract->current_status_id ? "style=color:#FFF;background-color:".$status_change->status->color : "" }}>
												<td>{{ __($status_change->status->name_english) }}</td>
												<td>{{ date("d/m/Y H:i:s", strtotime($status_change->created_at)) }}</td>
											</tr>
											@endforeach
											

										</tbody>
									</table>
									
									<div class="well">
										<div class="row">
											<div class="col-md-8">
												<select class="form-control">

												</select>
											</div>
											<div class="col-md-4">
												<button class="btn btn-primary" type="button">Actualizar el estado</button>
											</div>
										</div>
									</div>
									

								</div>
							</div>


							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Detalles del pago</h3>
								</div>
								<div class="panel-body">
									
									
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
												({{ (new DateTime($contract->quotation->date_to))->diff(new DateTime($contract->quotation->date_from))->format("%a") }} días)
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


						</div>

					</div>

					@else
					<h3 class="page-title">Contratación</h3>
					<h3 style="text-align: center;">La contratación solicitada no existe</h3>
					@endif


				
@endsection


@section('custom-js')


@endsection