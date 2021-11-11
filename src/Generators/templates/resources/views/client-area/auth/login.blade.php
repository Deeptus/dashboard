@extends('web.layouts.app')
@section('title', __meta('home', 'title'))
@section('description', __meta('home', 'description'))
@section('keywords', __meta('home', 'keywords'))
@section('author', 'Bel-Lab')
@section('navbar_fixed', true)

@section('content')
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
        <div class="col-md-4">
            @include('client-area.auth.form-login')
        </div>
        <div class="col-md-8">
            @include('client-area.auth.form-register')
        </div>
    </div>
</div>
@endsection
