@extends('front.layouts.main')       

@php ($section = 'insurers') @endphp

@section('meta-tags')
    <meta name="robots" content="index, follow"> 
    <meta name="description" content="Información de @yield('title'). Cotiza y compra @yield('title') al mejor precio en {{ config('app.domain') }}.">
    <meta name="og:description" property="og:description" content="Información de @yield('title'). Cotiza y compra @yield('title') al mejor precio en {{ config('app.domain') }}."> 
@endsection


@section('content')
        
        <div class="container">
            <div class="gap"></div>

            @yield('insurer-description')

            <div class="gap"></div>
        </div>

@endsection


