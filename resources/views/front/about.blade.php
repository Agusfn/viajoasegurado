@extends('front.layouts.main')       

@section('title', __('front/support.title'))

@php ($section = 'about') @endphp


@section('meta-tags')
    <meta name="robots" content="index, follow"> 
    <meta name="description" content="Busca, cotiza y compra los seguros de viaje más accesibles del mercado en un sólo lugar.">
    <meta name="og:description" property="og:description" content="Busca, cotiza y compra los seguros de viaje más accesibles del mercado en un sólo lugar."> 
@endsection


@section('content')

        <div class="container">
            <h1 class="page-title">Acerca de nosotros</h1>
        </div>




        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class="text-bigger">Viajoasegurado.com trabaja de la mano con Aseguratuviaje.com en la venta on line de seguros de viaje y planes de asistencia en viaje, quienes trabajan desde el año 2002 siendo pioneros en la venta de seguros de viaje.</p>
                    <p class="text-bigger">Junto a ellos, contamos con una fuerte presencia digital y constantemente invertimos en la actualización de nuestras herramientas tecnológicas.</p>
                </div>
            </div>
            <div class="gap"></div>
        </div>
        <div class="bg-holder">
            <div class="bg-parallax" style="background-image:url({{ asset('front/img/nature.jpg') }});"></div>
            <div class="bg-mask"></div>
            <div class="bg-holder-content">
                <div class="container">
                    <div class="gap gap-big text-white">
                        <div class="row">
                            <div class="col-md-10">
                                <p class="text-bigger"><strong>Trabajamos con planes y productos de más de 20 aseguradoras no solo en Viajoasegurado.com</strong>, sino también  web afiliadas, así como en sitios personalizados para países de los que se encuentran: <strong>Argentina, Brasil, Ecuador, España, Estados Unidos, Chile, Colombia, México, Perú y Venezuela</strong>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-8">
                    <p class="text-bigger"><strong>Viajoasegurado.com es un sitio 100% seguro, certificado por Let's Encrypt.</strong></p>

                    <p class="text-bigger">Con Viajoasegurado.com <strong>podrás hacer la compra online de tu plan de asistencia al viajero con total confianza</strong> y con la certeza que -luego del pago- la póliza será enviada a tu correo electrónico en cuestión de horas y ¡estará lista para ser usada!</p>
                    <p class="text-bigger"><strong>¡Viajoasegurado.com te ayuda a comparar las diferentes opciones con las empresas líderes en el mercado!</strong></p>
                </div>
            </div>
            <div class="gap"></div>
            
        </div>



@endsection