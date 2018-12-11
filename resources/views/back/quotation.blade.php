@extends('backoffice.layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    
                   @if ($quotation != null)


                        <div>Pais desde: {{ $quotation->origin_country_code }}</div>
                        <div>Hacia: {{ $quotation->destination_region_code }}</div>
                        <div>Fechas: {{ date('d/m/Y',strtotime($quotation->date_from)) }}-{{ date('d/m/Y',strtotime($quotation->date_to)) }}</div>
                        <div>Cantidad de pasajeros: {{ $quotation->passenger_ammount }}</div>
                        <div>Edades: {{ $quotation->passenger_ages }}</div>
                        <div>Email: {{ $quotation->customer_email }}</div>
                        <div>Productos cotizados: {{ $quotation->products()->count() }}</div>

                        <br/>
                        <h4>Productos cotizados:</h4>

                        <table class="table">

                            <thead>
                                <th>Proveedor</th>
                                <th>Producto</th>
                                <th>Cobertura</th>
                                <th>Costo</th>
                            </thead>

                            <tbody>
                                @foreach ($quotationProducts as $product)
                                <tr>
                                    <td>{{ $product->provider }}<br/><img src="{{ $product->img_url }}" height="60" /></td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>
                                        Enfermedad: {{ $product->disease_insured_amt }}<br/>
                                        Accidente: {{ $product->accident_insured_amt }}<br/>
                                        Equipaje: {{ $product->baggage_insured_amt }}<br/>
                                        <a href="{{ $product->terms_url }}">Términos y condiciones</a>
                                    </td>
                                    <td>{{ $product->cost }} USD</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                   @else

                    <h3>La cotización solicitada no existe</h3>

                   @endif

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
