@extends('web.layouts.app')
@section('title', __meta('home', 'title'))
@section('description', __meta('home', 'description'))
@section('keywords', __meta('home', 'keywords'))
@section('author', 'Bel-Lab')
@section('navbar_fixed', true)

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-md-8 offset-md-2">
            <div class="row">
                <div class="col-2 offset-2 col-md-auto offset-md-0 my-2 my-md-5"><i class="fas fa-map-marker-alt contact-icon"></i></div>
                <div class="col-8 col-md my-2 my-md-5">
                    <div class="parrafo-title mb-2">Dirección</div>
                    <div class="parrafo">{{ $companyData->contacto_direccion }}</div>
                </div>
                <div class="col-2 offset-2 col-md-auto offset-md-0 my-2 my-md-5"><i class="fas fa-phone-alt contact-icon"></i></div>
                <div class="col-8 col-md my-2 my-md-5">
                    <div class="parrafo-title mb-2">Teléfono</div>
                    <div class="parrafo">{{ $companyData->contacto_telefono }}</div>
                </div>
                <div class="col-2 offset-2 col-md-auto offset-md-0 my-2 my-md-5"><i class="fas fa-envelope contact-icon"></i></div>
                <div class="col-8 col-md my-2 my-md-5">
                    <div class="parrafo-title mb-2">Email</div>
                    <div class="parrafo">{{ $companyData->contacto_email }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<form-contacto url-action="{{ route('website.contact') }}" leyenda="{{ $companyData->contacto_leyenda }}"></form-contacto>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6569.691631385016!2d-58.462605177361304!3d-34.58276769462668!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcb5e053469ce9%3A0xde541d8bf5fb116f!2sDistribuidora+Van+Rossum+S.R.L.!5e0!3m2!1ses-419!2sar!4v1554324168691!5m2!1ses-419!2sar" width="600" height="450" frameborder="0" class="w-100 mb-5" style="border:0" allowfullscreen></iframe>

@endsection
