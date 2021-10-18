@extends('Dashboard::layouts.dashboard')
@section('content')
<table  class="table align-middle table-striped table-bordered">
    <tbody>
        <tr>
            <td class="title">Nombre:</td>
            <td>{{ $message->name }}</td>
        </tr>
        <tr>
            <td class="title">Empresa:</td>
            <td>{{ $message->company }}</td>
        </tr>
        <tr>
            <td class="title">Teléfono:</td>
            <td>{{ $message->phone }}</td>
        </tr>
        <tr>
            <td class="title">Email:</td>
            <td>{{ $message->email }}</td>
        </tr>
        @if($message->address)
        <tr>
            <td class="title">Dirección:</td>
            <td>{{ $message->address }}</td>
        </tr>
        @endif
        <tr>
            <td class="title" colspan="2">Consulta:</td>
        </tr>
        <tr>
            <td colspan="2">{{ $message->message }}</td>
        </tr>
    </tbody>
</table>
@if ($message->items && count($message->items) && $message->type == 'budget')
<table class="table align-middle table-striped table-bordered">
    <thead>
        <tr>
            <th style="width: 70px;"></th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($message->items as $item)
        <tr>
            <td><div style="background-image: url('{{ $item->image_url }}');width: 50px;height: 50px;background-position: center;background-size: cover;background-repeat: no-repeat;margin: auto;"></div></td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection