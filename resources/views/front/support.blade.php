@extends('front.layouts.main')       


@section('title', '')


@php ($section = 'support') @endphp



@section('content')
	
		<div>
			<div class="container">
				<div class="gap"></div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-1">
						<h3>Formulario de contacto</h3>
						@include('front.layouts.errors')
						{{ Form::open( array("method" => "post", "url" => uri_localed('{support}'), "style" => "padding-bottom:35px", "id" => "contact-form") ) }}

							<div class="form-group">
								<label>Nombre</label>
								<input type="text" class="form-control" name="name" maxlength="100">
							</div>
							<div class="form-group">
								<label>E-mail</label>
								<input type="text" class="form-control" name="email" maxlength="100">
							</div>
							<div class="form-group">
								<label>Motivo</label>
								<select class="form-control" name="reason">
									<option value="select">Seleccionar</option>
									<option value="inquire">Consulta</option>
									<option value="inquire-contract">Consulta/reclamo con una compra</option>
									<option value="other">Otro</option>
								</select>
							</div>
							<div class="form-group" id="contract-no-field" style="display: none">
								<label>Número de contratación</label>
								<input type="text" class="form-control" name="contract_number">
							</div>
							<div class="form-group">
								<label>Mensaje</label>
								<textarea class="form-control" style="resize: vertical;" name="message"></textarea>
							</div>
							<div class="form-group" style="text-align: right;">
								<input type="button" class="btn btn-primary" value="Enviar consulta" id="submit-btn" />
							</div>				
						{{ Form::close() }}
					</div>
					<div class="col-sm-4 col-sm-offset-1">
						<h4>Otros medios de contacto</h4>
						asdasd
					</div>
				</div>

			</div>
		</div>

@endsection


@section('custom-js')
<script>
$(document).ready(function() {
	
	$("select[name=reason]")[0].selectedIndex = 0;

	$("select[name=reason]").change(function() {
		if($(this).val() == "inquire-contract")
			$("#contract-no-field").show();
		else
			$("#contract-no-field").hide();
	});

	$("#submit-btn").click(function() {

		if($("input[name=name]").val() == "" || $("input[name=email]").val() == "" || $("textarea[name=message]").val() == "") {
			alert("Completa todos los campos.");
			return;
		}

		if($("select[name=reason]").val() == "select") {
			alert("Selecciona el motivo de la consulta.");
			return;
		}

		if($("select[name=reason]").val() == "inquire-contract" && $("input[name=contract_number]").val() == "") {
			alert("Ingresa el numero de contratación.");
			return;
		}

		$("#contact-form").submit();
	});

});
</script>
@endsection