@extends('back.layouts.main')

@php ($section = 'users')

@section('title', 'Cuentas')


@section('content')
			
			<p><a href="{{ url('users') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver a cuentas</a></p>
			
			@if($user == null)

				<h3 style="text-align: center;">No se encontró el usuario</h3>

			@else

				<div class="panel">
					<div class="panel-heading">
						<h3 class="panel-title" style="display: inline-block;">Cuenta ID #{{ $user->id }}</h3>
						@if ($can_modify)
						{{ Form::open(['method' => 'post', 'url' => url('users/'.$user->id.'/delete'), 'style' => 'float:right']) }}
						<input type="button" class="btn btn-danger" value="Eliminar" onclick="if(confirm('¿Deseas eliminar esta cuenta?')) $(this).parent().submit();" />
						{{ Form::close() }}
						@endif
					</div>
					<div class="panel-body">

						@include('back.layouts.errors-sign')
						
						@if (\Session::has("success"))
						<div class="alert alert-success">Los datos se actualizaron correctamente.<button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button></div> 
						@endif
						
						<div class="row">
							<div class="col-sm-6 col-sm-offset-3" style="margin-bottom: 35px">

								{{ Form::open(["method" => "post", "url" => url('users/'.$user->id), "autocomplete" => "off"]) }}

								<div class="form-group">
									<label>Tipo de cuenta <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="El operativo puede ver y administrar las cotizaciones y las ventas. El administrador además puede administrar cuentas de operativos y configuraciones del sitio. El super admin además administra administradores."></span></label>
									
				
									<select class="form-control" name="tipo_cuenta" @if(!$can_modify) disabled="" @endif>
										@if($user->isSuperAdmin())
										<option value="superadmin" selected>Super administrador</option>
										@endif
										@if(!$can_modify || Auth::user()->isSuperAdmin())
										<option value="admin" @if($user->isAdmin()) selected @endif>Administrador</option>
										@endif
										<option value="operative" @if($user->isOperative()) selected @endif>Operativo</option>
									</select>

								</div>

								<div class="form-group">
									<label>Nombre de usuario</label>
									<input type="text" class="form-control" name="nombre_usuario" value="{{ $user->name }}" @if(!$can_modify) disabled="" @endif>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="text" class="form-control" name="email" value="{{ $user->email }}" @if(!$can_modify) disabled="" @endif>
								</div>
								<div class="form-group">
									<label>Contraseña</label>
									<input type="password" class="form-control" name="password" value="" placeholder="Dejar vacio para no cambiar" @if(!$can_modify) disabled="" @endif>
								</div>
								<div class="form-group">
									<label>Repetir contraseña</label>
									<input type="password" class="form-control" name="password_repeat" value="" @if(!$can_modify) disabled="" @endif>
								</div>		
								<div class="form-group">
			  						<div class="checkbox">
			  							<label><input type="checkbox" name="disable_account" @if($user->disabled) checked @endif @if(!$can_modify) disabled="" @endif> Cuenta inhabilitada</label>
			  						</div>
								</div>

								@if($can_modify)
								<button class="btn btn-success" style="float: right;">Guardar</button>
								@endif

								{{ Form::close() }}
							</div>
						</div>

						

					</div>

				</div>

			@endif


@endsection



@section('custom-js')
@endsection