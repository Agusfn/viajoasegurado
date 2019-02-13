@extends('back.layouts.main')

@php ($section = 'users')

@section('title', 'Crear cuenta')


@section('content')
			
			<p><a href="{{ url('users') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver a cuentas</a></p>
			

			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">Crear cuenta</h3>
				</div>
				<div class="panel-body">

					@include('back.layouts.errors-sign')
					
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3" style="margin-bottom: 35px">

							{{ Form::open(["method" => "post", "url" => url('users/create') ]) }}

							<div class="form-group">
								<label>Tipo de cuenta <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="El operativo puede ver y administrar las cotizaciones y las ventas. El administrador además puede administrar cuentas de operativos y configuraciones del sitio. El super admin además administra administradores."></span></label>
								
								<select class="form-control" name="tipo_cuenta">
									<option value="select">Seleccionar</option>
									@if(Auth::user()->isSuperAdmin()) <option value="admin">Administrador</option> @endif
									<option value="operative">Operativo</option>
								</select>

							</div>

							<div class="form-group">
								<label>Nombre de usuario</label>
								<input type="text" class="form-control" name="nombre_usuario" value="{{ old('nombre_usuario') }}" maxlength="50">
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="text" class="form-control" name="email" value="{{ old('email') }}" maxlength="100">
							</div>
							<div class="form-group">
								<label>Contraseña</label>
								<input type="password" class="form-control" name="password">
							</div>
							<div class="form-group">
								<label>Repetir contraseña</label>
								<input type="password" class="form-control" name="password_repeat">
							</div>								
							<button class="btn btn-success" style="float: right;">Guardar</button>

							{{ Form::close() }}
						</div>
					</div>

					

				</div>

			</div>



@endsection



@section('custom-js')
@endsection