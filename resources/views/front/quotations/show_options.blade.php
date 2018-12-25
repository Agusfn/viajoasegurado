@extends('front.layouts.main')


@section('scripts')
@if ($quotationFound && !$quotationExpired)
	<meta name="url-code" content="{{ $url_code }}" />

	<script type="text/javascript">

		$(document).ready(function() {

			var quot_url_code = $('meta[name="url-code"]').attr('content');
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			$("#loading").show();
           
            $.ajax({
                url: "{{ url()->to('quotation/getquotation') }}",

                type: 'POST',

                data: {_token: CSRF_TOKEN, url_code: quot_url_code},

                dataType: 'JSON',
                success: function (data) {

                	$("#loading").hide(); 
                    console.log(data);

                    if(data.success)
                    {

                		data.products.forEach(function(entry) {
                			// entry tiene todos los datos expuestos
                			var elem = createProductElement(entry, quot_url_code);
                			$("#product-list").append(elem);
						});

                    }
                }
            }); 


            $("body").on("click", ".view_product_details", function() {

            	var product_atvid = $(this).parent().parent().attr("product_atvid");

	            $.ajax({
	                url: "{{ URL::to('quotation/getproductcoverage') }}",

	                type: 'POST',

	                data: {_token: CSRF_TOKEN, quot_url_code: quot_url_code, product_atv_id: product_atvid},

	                dataType: 'JSON',
	                success: function (data) {

	                    console.log(data);

	                    if(data.success)
	                    {

	                    	var display = "";

	                    	data.coverage.forEach(function(elem) {
	                    		display += elem.description + ": " + elem.ammount + "\n";
	                    	});	

	                    	alert(display);

	                    }
	                },
	            });


            });


		});


		function createProductElement(entry, quotation_url_code)
		{
			var a = "";
			a += "<div product_atvid='"+entry.product_atv_id+"'>";
			a += "<img src='"+entry.img_url+"'/>";
			a += "<p>"+entry.product_name+"</p>";
			a += "<p>Precio: "+entry.price+" "+entry.price_currency_code+"</p>";
			a += "<p><a href='"+entry.terms_url+"'>Condiciones</a></p>";
			a += "<p>Cobertura Enfermedad: "+entry.disease_insured_amt+"</p>";
			a += "<p>Cobertura Accidente: "+entry.accident_insured_amt+"</p>";
			a += "<p>Cobertura Equipaje: "+entry.baggage_insured_amt+"</p>";
			a += "<p><a href='javascript:void(0);' class='view_product_details'>Ver detalles de montos de coberturas</a></p>";
			a += "<p><a href='{{ URL::to(uri_localed('{contract}')) }}/"+quotation_url_code+"/"+entry.product_atv_id+"'>Contratar</a></p>";
			a += "<br/><br/><br/>";
			a += "</div>";

			return a;
		}

	</script>
	@endif
@endsection

		

@section('content')

	@if($quotationFound)

		@if(!$quotationExpired)
		
			<div id="loading" style="display:none;"><strong>Cargando precios de cotización</strong></div>

			<div id="product-list"></div>
		
		@else
			<h3>La cotización expiró, realiza otra.</h3>
		@endif

	@else

		<h3>No se encontró la cotización</h3>

	@endif

@endsection