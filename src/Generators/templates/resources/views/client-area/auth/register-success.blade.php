@extends('client-area.layouts.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 title-section">
            <h1>{{ $config['title-register-success'] }}</h1>
            <hr>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
           {!! $config['text-register-success'] !!}
        </div>
    </div>
</div>
@endsection
