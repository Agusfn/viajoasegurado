@extends('back.layouts.main')

@php ($section = 'users')

@section('title', 'Cuentas')


@section('content')
			
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title" style="display: inline-block;">Cuentas de administrador</h3>
					<a href="{{ url('users/new') }}" class="btn btn-primary" style="float: right;"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
				</div>
				<div class="panel-body">


					<table class="table">

						<thead>
							<tr>
								<th></th>
								<th>Nombre usuario</th>
								<th>Tipo usuario</th>
								<th>Email</th>
								<th>Últ. actividad</th>
								<th>Cta. habilitada</th>
							</tr>

						</thead>

						<tbody>
							
							@foreach($users as $user)

								<tr>
									<td><a href="{{ url('users/'.$user->id) }}" class="btn btn-sm btn-primary">Ver</a></td>
									<td>{{ $user->name }}</td>
									<td>
										@if($user->role == 'superadmin')
											Super admin
										@elseif($user->role == 'admin')
											Administrador
										@elseif($user->role == 'operative')
											Operativo
										@endif
									</td>
									<td>{{ $user->email }}</td>
									<td>{{ date('d/m/Y H:i:s', strtotime($user->last_activity)) }}</td>
									<td>
										@if($user->disabled)
											<span class="glyphicon glyphicon-remove" style="color: #D70D0D"></span>
										@else
											<span class="glyphicon glyphicon-ok" style="color: #26B426"></span>
										@endif
									</td>
								</tr>

							@endforeach

						</tbody>

					</table>

				</div>

			</div>


@endsection



@section('custom-js')
@endsection