@extends('front.layouts.main')       

@section('title', __('front/support.title'))

@php ($section = 'support') @endphp


@section('meta-tags')
    <meta name="robots" content="index, follow"> 
    <meta name="description" content="{{ __('front/support.meta_description') }}">
    <meta name="og:description" property="og:description" content="{{ __('front/support.meta_description') }}"> 
@endsection


@section('content')
		

		<div id="map-canvas" style="height:400px;"></div>
		<div>
			<div class="container">
				<div class="gap"></div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-1">
						@if (Session::has('success'))
						<div class="alert alert-success">{{ __('front/support.success_msg') }}</div>
						@endif
						<h3>{{ __('front/support.contact_form') }}</h3>
						@include('front.layouts.errors')
						{{ Form::open( array("method" => "post", "url" => uri_localed('{support}'), "style" => "padding-bottom:35px", "id" => "contact-form") ) }}

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>{{ __('front/support.name') }}</label>
										<input type="text" class="form-control" name="name" maxlength="100">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>{{ __('front/support.email') }}</label>
										<input type="text" class="form-control" name="email" maxlength="100">
									</div>
								</div>
							</div>


							<div class="form-group">
								<label>{{ __('front/support.subject') }}</label>
								<select class="form-control" name="reason">
									<option value="select">{{ __('front/support.select') }}</option>
									<option value="inquire">{{ __('front/support.inquire') }}</option>
									<option value="inquire-contract">{{ __('front/support.contract_inquire') }}</option>
									<option value="other">{{ __('front/support.other') }}</option>
								</select>
							</div>
							<div class="form-group" id="contract-no-field" style="display: none">
								<label>{{ __('front/support.contract_number') }}</label>
								<input type="text" class="form-control" name="contract_number">
							</div>
							<div class="form-group">
								<label>{{ __('front/support.message') }}</label>
								<textarea class="form-control" style="resize: vertical;" name="message"></textarea>
							</div>
							<div class="form-group" style="text-align: right;">
								<input type="button" class="btn btn-primary" value="{{ __('front/support.send_message') }}" id="submit-btn" />
							</div>				
						{{ Form::close() }}
					</div>
					<div class="col-sm-4 col-sm-offset-1">
	                    <aside class="sidebar-right">
	                        <ul class="address-list list">
	                            <li>
	                                <h5>Email</h5><a href="#">{{ __('front/support.contact_email') }}</a>
	                            </li>
	                            <li>
	                                <h5>Whatsapp</h5><a href="#">+54 9 11 4146 0319</a>
	                            </li>
	                            <li>
	                                <h5>Skype</h5><a href="#">viajoasegurado</a>
	                            </li>
	                            <li>
	                                <h5>{{ __('front/support.address') }}</h5>
	                                <address>Viajoasegurado SAS.<br />Alicia Moreau de Justo 1150, piso 3, oficina 306-A<br />
	                                	Ciudad de Buenos Aires, CPAAX1107<br />
	                                	Argentina<br />
	                                </address>
	                            </li>
	                            <li>&nbsp;</li>
	                            <li>&nbsp;</li>
	                        </ul>
	                    </aside>

					</div>
				</div>

			</div>
		</div>

@endsection


@section('custom-js')
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
$(document).ready(function() {
	

	if ($('#map-canvas').length) {
	    var map,
	        service;

	    jQuery(function($) {
	        $(document).ready(function() {
	            var latlng = new google.maps.LatLng(-34.610951, -58.366343);
	            var myOptions = {
	                zoom: 16,
	                center: latlng,
	                mapTypeId: google.maps.MapTypeId.ROADMAP,
	                scrollwheel: false
	            };

	            map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);


	            var marker = new google.maps.Marker({
	                position: latlng,
	                map: map
	            });
	            marker.setMap(map);


	            $('a[href="#google-map-tab"]').on('shown.bs.tab', function(e) {
	                google.maps.event.trigger(map, 'resize');
	                map.setCenter(latlng);
	            });
	        });
	    });
	}


	$("select[name=reason]")[0].selectedIndex = 0;

	$("select[name=reason]").change(function() {
		if($(this).val() == "inquire-contract")
			$("#contract-no-field").show();
		else
			$("#contract-no-field").hide();
	});

	$("#submit-btn").click(function() {

		if($("input[name=name]").val() == "" || $("input[name=email]").val() == "" || $("textarea[name=message]").val() == "") {
			alert("{{ __('front/support.error_fill_all_inputs') }}");
			return;
		}

		if($("select[name=reason]").val() == "select") {
			alert("{{ __('front/support.error_select_subject') }}");
			return;
		}

		if($("select[name=reason]").val() == "inquire-contract" && $("input[name=contract_number]").val() == "") {
			alert("{{ __('front/support.error_insert_contract_no') }}");
			return;
		}

		$("#contact-form").submit();
	});

});
</script>
@endsection