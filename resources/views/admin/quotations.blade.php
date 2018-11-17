@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    
                    <table class="table">
                        
                        <thead>
                            <th></th>
                            <th>País origen</th>
                            <th>Destino</th>
                            <th>Fechas</th>
                            <th>Cantidad pasaj.</th>
                            <th>Edades</th>
                            <th>Email</th>
                            <th>Productos cotiz.</th>
                        </thead>
                        <tbody>
                            
                            @foreach($quotations as $quotation)
                            <tr>
                                <td><a href="{{ URL::to('backoffice/cotizaciones/'.$quotation->id) }}" class="btn btn-primary btn-sm">Ver detalles</a></td>
                                <td>{{ $quotation->origin_country_code }}</td>
                                <td>{{ $quotation->destination_region_code }}</td>
                                <td>{{ date('d/m/Y',strtotime($quotation->date_from)) }}-{{ date('d/m/Y',strtotime($quotation->date_to)) }}</td>
                                <td>{{ $quotation->passenger_ammount }}</td>
                                <td>{{ $quotation->passenger_ages }}</td>
                                <td>{{ $quotation->customer_email }}</td>
                                <td>{{ $quotation->products()->count() }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
