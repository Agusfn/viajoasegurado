
Opciones:
<br/>
<br/>

@foreach ($results["Productos"] as $producto)
	<img src="{{ $producto['UrlIMG'] }}"/>
    <p>{{ $producto["Producto"] }}</p>
    <p>Precio: ${{ $producto["CostoOrigen"] }}</p>
    <p><a href="{{ $producto['Condiciones'] }}">Condiciones</a></p>
    <p>Cobertura Enfermedad: {{ $producto["CoberturaEnfermedad"] }}</p>
    <p>Cobertura Accidente: {{ $producto["CoberturaAccidente"] }}</p>
    <p>Cobertura Equipaje: {{ $producto["CoberturaEquipaje"] }}</p>
    <br/><br/><br/>
@endforeach