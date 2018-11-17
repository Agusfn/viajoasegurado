<html>


{{ Form::open( array("url" => "cotizar", "method" => "post") ) }}

	<label>Pais desde (Codigo)</label><br/>
	<input type="text" name="pais_desde" ><br/>

	<label>Region hacia (Codigo)</label><br/>
	<input type="text" name="pais_hasta" ><br/>

	<label>Tipo viaje (Codigo)</label><br/>
	<input type="text" name="tipo_viaje" ><br/>

	<label>Fecha desde (YYYY-MM-DD)</label><br/>
	<input type="text" name="fecha_desde" ><br/>

	<label>Fecha hasta (YYYY-MM-DD)</label><br/>
	<input type="text" name="fecha_hasta" ><br/>

	<label>Cantidad de pasajeros</label><br/>
	<input type="text" name="cant_pasaj" ><br/>

	<label>Edades</label><br/>
	<input type="text" name="edades" ><br/>

	<label>Semana gestacion</label><br/>
	<input type="text" name="semana_gestacion" ><br/>

	<label>Email</label><br/>
	<input type="text" name="email" ><br/>


	<br/>
	<input type="submit" value="cotizar" />

{{ Form::close() }}

</html>