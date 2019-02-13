@extends('back.layouts.main')

@section('title', 'Mi cuenta')


@section('content')
			
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">Mi cuenta</h3>
				</div>
				<div class="panel-body">

					@if (\Session::has("success"))
					<div class="alert alert-success">Los datos se actualizaron correctamente.</div> 
					@endif

					@include('back.layouts.errors-sign')

					{{ Form::open( array("url" => url("account"), "method" => "post") ) }}
					<div class="row" style="margin-top: 70px">
						<div class="col-sm-3 col-sm-offset-2">Tipo de usuario</div>
						<div class="col-sm-2">
							@if($user->role == 'superadmin')
								Super admin
							@elseif($user->role == 'admin')
								Administrador
							@elseif($user->role == 'operative')
								Operativo
							@endif
						</div>
					</div>
					<div class="row" style="margin-top: 20px">
						<div class="col-sm-3 col-sm-offset-2">Nombre de usuario</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="name" value="{{ $user->name }}">
						</div>
					</div>
					<div class="row" style="margin-top: 20px">
						<div class="col-sm-3 col-sm-offset-2">E-mail</div>
						<div class="col-sm-2">{{ $user->email }}</div>
					</div>
					<div class="row" style="margin-top: 20px">
						<div class="col-sm-3 col-sm-offset-2">Password</div>
						<div class="col-sm-2">
							<input type="password" class="form-control" name="current_password" placeholder="Contraseña actual"><br/>
							<input type="password" class="form-control" name="new_password" placeholder="Contraseña nueva">
							<input type="password" class="form-control" name="new_password_2" placeholder="Repetir contraseña">
						</div>
					</div>					
					<div style="text-align: right; margin-top: 50px">
						<input type="submit" class="btn btn-primary" value="Guardar">
					</div>
					{{ Form::close() }}

				</div>

			</div>


@endsection



@section('custom-js')
@endsection