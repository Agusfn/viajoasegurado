@extends('backoffice.layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    
                   <h2>Panel Admin</h2>

                   <a href="{{ URL::to('quotations') }}">Cotizaciones</a><br/>
                   <a href="">Contrataciones</a>



                </div>

            </div>
        </div>
    </div>
</div>
@endsection
