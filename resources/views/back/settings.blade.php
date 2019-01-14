@extends('back.layouts.main')

@section('title', 'Configuración')

@php ($section = 'settings')


@section('content')
			
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">Configuración</h3>
				</div>
				<div class="panel-body">

		            @if($errors->any())
		            <div class="alert alert-danger alert-dismissible" role="alert">
		                <button type="button" class="close" aria-label="Close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
		                @foreach ($errors->all() as $error)
		                    <div>{{ $error }}</div>
		                @endforeach
		            </div>
		            @endif

					{{ Form::open( array("url" => url("settings"), "method" => "post") ) }}
					<div class="row" style="margin-top: 70px">
						<div class="col-sm-3 col-sm-offset-2">
							Cotización USD a EUR <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="Los seguros de viajes con orígen en España nos lo cobra aseguratuviaje.com en euros únicamente. Esta cotización nos sirve para convertirlo a dólares y cobrarlo en USD."></span>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="usd_to_eur_rate" value="{{ $usd_to_eur }}">
						</div>
					</div>
					<div class="row" style="margin-top: 20px">
						<div class="col-sm-3 col-sm-offset-2">
							Margen ganancia (%) <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="top" title="El porcentaje sobre el total que nos pasa aseguratuviaje.com que corresponde a nuestra comisión. Si nos pasan un total de $200 y hay 20% de margen, $40 son comisión y $160 costo."></span>
						</div>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="profit_margin" value="{{ $profit_margin }}">
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
<script>
$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection