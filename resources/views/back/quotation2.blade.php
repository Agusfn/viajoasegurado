@extends('back.layouts.main2')

@section('title', 'Cotizaciones')

@php ($section = 'quotations')


		
@section('content')
					
					<p><a href="{{ url('quotations') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver a cotizaciones</a></p>
					<h3 class="page-title">Detalles cotización</h3>
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Detalles de la cotización</h3>
						</div>
						<div class="panel-body">
							

						</div>

					</div>

					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Productos cotizados</h3>
						</div>
						<div class="panel-body">
							

						</div>

					</div>


@endsection