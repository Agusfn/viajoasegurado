<!DOCTYPE html>
<html>
	<head>
		<title></title>


		<script type="text/javascript" src="{{ asset('resources/vendor/jquery-3.3.1.min.js') }}"></script>

		@if ($quotationFound && !$quotationExpired)
		<meta name="url-code" content="{{ $url_code }}" />
	    <meta name="csrf-token" content="{{ csrf_token() }}" />

		<script type="text/javascript">

			$(document).ready(function() {

				var url_code = $('meta[name="url-code"]').attr('content');
				var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

				$("#loading").show();
	            $.ajax({
	                url: "{{ URL::to('cotizar/obtener') }}",

	                type: 'POST',

	                data: {_token: CSRF_TOKEN, url_code: url_code},

	                dataType: 'JSON',
	                success: function (data) {

	                	$("#loading").hide(); 
	                    console.log(data);


	                    if(data.success)
	                    {

                    		data.products.forEach(function(entry) {

                    			var elem = createProductElement(entry.img_url, entry.product_name, entry.orig_cost, entry.terms_url, entry.disease_insured_amt, entry.accident_insured_amt, entry.baggage_insured_amt);

                    			$("#product-list").append(elem);

							});

	                    }

	                }
	            }); 

			});


			function createProductElement(imgurl, product_name, costo_origen, cond_url, cob_enf, cob_acc, cob_equip)
			{
				var a = "";
				a += "<img src='"+imgurl+"'/>";
				a += "<p>"+product_name+"</p>";
				a += "<p>Precio: $"+costo_origen+"</p>";
				a += "<p><a href='"+cond_url+"'>Condiciones</a></p>";
				a += "<p>Cobertura Enfermedad: "+cob_enf+"</p>";
				a += "<p>Cobertura Accidente: "+cob_acc+"</p>";
				a += "<p>Cobertura Equipaje: "+cob_equip+"</p>";
				a += "<br/><br/><br/>";

				return a;
			}

		</script>
		@endif

		</script>

	</head>

	<body>


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


	</body>
</html>

