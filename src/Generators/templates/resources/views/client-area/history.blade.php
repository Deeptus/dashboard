@extends('client-area.layouts.app')

@section('client-content')
<pedidos-client
url-data="{{ route('client.history.data') }}"
></pedidos-client>
@endsection
