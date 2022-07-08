@extends('client-area.layouts.app')

@section('client-content')
<cart
url-action="{{ $privatezone->check() ? route('client.order.generate') : route('client.login') }}"
action="{{ $privatezone->check() ? 'payment' : 'redirect' }}"
url-oca="{{ route('website.calculate-oca') }}"
url-data="{{ route('website.cart.data') }}"
></cart>
@endsection
