@extends('front.layouts.main')


@section('scripts')

	<script>

		$(document).ready(function() {

			$("#travel_pregnant").on("change", function() {

				if($(this).is(":checked"))
				{
					$("#gest-weeks").show();
					$("#passenger_ammt").val("1").trigger("change").prop("disabled", true);
				}
				else
				{
					$("#gest-weeks").hide();
					$("#passenger_ammt").prop("disabled", false);
				}

			});

			$("#passenger_ammt").on("change", function() {

				var val = parseInt($(this).val());
				$("#passenger_ammt_hidden").val(val);

				$("#age2,#age3,#age4,#age5").hide();
				for(var i=1; i<(val+1); i++)
				{
					$("#age"+i).show();
				}

			});

		});

	</script> 

@endsection



@section('content')


{{ Form::open( array("url" => uri_localed("quotation/create"), "method" => "post") ) }}

	<label>@lang("front/home.country_from"):</label><br/>

	<select name="country_from_id">
		@foreach($countries_from as $country)
		<option value="{{ $country['id'] }}">{{ $country["name"] }}</option>
		@endforeach
	</select>
	<br/><br/>
	<label>@lang("front/home.region_to"):</label><br/>

	<select name="region_to_id">
		@foreach($regions_to as $region)
		<option value="{{ $region['id'] }}">{{ $region["name"] }}</option>
		@endforeach
	</select>
	<br/><br/>
	<label>{{ __("front/home.trip_type") }}</label><br/>
	<input type="text" name="trip_type" ><br/>

	<label>{{ __("front/home.date_from") }}</label><br/>
	<input type="text" name="date_from" ><br/>

	<label>{{ __("front/home.date_to") }}</label><br/>
	<input type="text" name="date_to" ><br/><br/>

	<div class="form-group">
		<label>
			<input type="checkbox" name="travel_pregnant" id="travel_pregnant"> {{ __("front/home.travel_pregnant") }}
		</label>
	</div>

	<div class="form-group" id="gest-weeks" style="display: none">
		<label>{{ __("front/home.gestation_weeks") }}</label><br/>
		<input type="text" name="gestation_weeks" style="width: 60px">
	</div>


	<div class="form-group">
		<label>{{ __("front/home.travelers_count") }}</label><br/>
		<select id="passenger_ammt">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<input type="hidden" name="passenger_ammt" id="passenger_ammt_hidden" value="1">
	</div>


	<div class="form-group">
		<label>{{ __("front/home.ages") }}</label><br/>
		<input type="text" name="age1" id="age1" placeholder="1º" style="width: 60px">
		<input type="text" name="age2" id="age2" placeholder="2º" style="width: 60px;display: none;">
		<input type="text" name="age3" id="age3" placeholder="3º" style="width: 60px;display: none;">
		<input type="text" name="age4" id="age4" placeholder="4º" style="width: 60px;display: none;">
		<input type="text" name="age5" id="age5" placeholder="5º" style="width: 60px;display: none;">
	</div>

	<div class="form-group">
		<label>{{ __("front/home.email") }}</label><br/>
		<input type="text" name="email" >
	</div>

	<br/>
	<input type="submit" value="{{ __('front/home.quote') }}" />

{{ Form::close() }}
@endsection
