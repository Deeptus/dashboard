@extends('web.layouts.app')
@section('title', __meta('home', 'title'))
@section('description', __meta('home', 'description'))
@section('keywords', __meta('home', 'keywords'))
@section('author', 'Bel-Lab')
@section('navbar_fixed', true)

@section('content')
<main class="products">
    <section class="products__section">
        <article class="products__breadcumb">
            <div class="container py-2">
                <a class="breadcumb-name" href="{{ route('website') }}">INICIO</a>
                <a class="breadcumb-name" href="{{ route('website.offers') }}">AREA DE CLIENTES</a>
            </div>
        </article>
    </section>
</main>

<div class="container">
    @if ($errors->any())
    <div class="row">
        <div class="col s12 m12">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-2">
            <div class="product-sidebar">
                    <div class="product-sidebar__title">MI CUENTA</div>
                    <ul class="product-sidebar__ul">
                        <li><a href="{{ route('client.home') }}">Carrito</a></li>
                        <li><a href="{{ route('client.history') }}">Mis compras</a></li>
                        {{--
                        <li><a href="">Editar Perfil</a></li>
                        <li><a href="">Cambiar Contraseña</a></li>
                        --}}
                        <li><a href="{{ route('client.logout') }}">Cerrar sesión</a></li>
                    </ul>
            </div>
        </div>
        <div class="col-md-10">
            @yield('client-content')
        </div>
    </div>
</div>
@endsection
