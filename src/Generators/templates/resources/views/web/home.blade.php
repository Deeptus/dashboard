@extends('web.layouts.app')
@section('title', __meta('home', 'title'))
@section('description', __meta('home', 'description'))
@section('keywords', __meta('home', 'keywords'))
@section('author', 'Bel-Lab')
@section('navbar_fixed', true)

@section('content')
<div class="container"><x-carousel :data="$banner" /></div>
<x-services/>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="block-header">
                <div class="block-header__title">Nuestras categorías</div>
            </div>
        </div>
    </div>
</div>
{{--
<div class="container mb-4">
    <div class="row">
        @foreach ($categories as $category)
        <div class="col col-md-3">
            <div class="category-card" style="background-color: {{ $category->color }}">
                <div class="category-card__image" style="background-image: url({{ $category->image['url'] }})"></div>
                <div class="category-card__title">{{ $category->name }}</div>
                <div class="category-card__btn">
                    <a class="btn-green" href="{{ route('website.products', $category->id) }}">Ver más <i class="fas fa-angle-right"></i></a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
--}}
<div class="container mb-4">
    <div class="row">
        @foreach ($categories as $category)
        <div class="col-6 col-md-3 mb-4">
            <a href="{{ route('website.products', $category->id) }}" class="image_instagram">
                <div style="background-image: url({{ $category->image_instagram['url'] }}); padding-bottom: 70%; background-position: center; background-size: cover; width: 100%;"></div>
                <div class="image_instagram__overlay" style="background-color: {{ $category->color }}"><i class="fas fa-plus"></i></div>
            </a>
        </div>
        @endforeach
    </div>
</div>
<carousel-products endpoint="{{ route('website.articulos.home.data') }}" title="Productos destacados"></carousel-products>
{{--<carousel-products class="mb-5" endpoint="{{ route('website.combos.home.data') }}" title="Combos"></carousel-products>--}}
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="block-header mt-5">
                <div class="block-header__title">Combos</div>
                <div class="block-header__controls"><a class="btn-lightgreen" href="{{ route('website.combos') }}">Ver todas los combos</a></div>
            </div>
        </div>
    </div>
</div>
<div class="container mb-5">
    <div class="row">
        @foreach ($combos as $combo)
        <div class="col-12 col-md-3">
            <a class="articulo-card" href="{{ route('website.combo', $combo->id) }}">
                <div class="articulo-card__image-container">
                    <div class="articulo-card__image" style="background-image: url({{ $combo->display_image }})"></div>
                    @if ($combo->offer > 0)
                    <div class="articulo-card__discount">{{ $combo->offer }}% OFF</div>
                    @endif
                </div>
                <div class="articulo-card__category">CATEGORIA</div>
                <div class="articulo-card__name">{{ $combo->name }}</div>
                <div class="articulo-card__price">
                    @if ($combo->offer > 0)
                    <div class="articulo-card__price--discount">$ {{ $combo->display_ref_price }}</div>
                    @endif
                    $ {{ $combo->display_price }}
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<x-time-limited-offers></x-time-limited-offers>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="block-header mt-5">
                <div class="block-header__title">Puntos de venta y Distribuidores</div>
                <div class="block-header__controls"><a class="btn-lightgreen" href="{{ route('website.dealers') }}">Ver todas los Distribuidores</a></div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-5">
            <x-distribuidores />
        </div>
    </div>
</div>
@endsection
