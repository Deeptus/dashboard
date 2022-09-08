@extends('Dashboard::layouts.dashboard')
@section('content')
<table class="table align-middle table-striped table-bordered">
    <tbody>
        @if(count($inputs) == 0)
            <tr>
                <th>Nombre:</th>
                <td>{{ $message->name }}</td>
            </tr>
            <tr>
                <th>Empresa:</th>
                <td>{{ $message->company }}</td>
            </tr>
            <tr>
                <th>Teléfono:</th>
                <td>{{ $message->phone }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $message->email }}</td>
            </tr>
            @if($message->address)
                <tr>
                    <th>Dirección:</th>
                    <td>{{ $message->address }}</td>
                </tr>
            @endif
            @if($message->provincia)
                <tr>
                    <th>Provincia:</th>
                    <td>{{ $message->provincia }}</td>
                </tr>
            @endif
            @if($message->localidad)
                <tr>
                    <th>Localidad:</th>
                    <td>{{ $message->localidad }}</td>
                </tr>
            @endif
            @if($message->direccion)
                <tr>
                    <th>Dirección:</th>
                    <td>{{ $message->direccion }}</td>
                </tr>
            @endif
            <tr>
                <th colspan="2">Consulta:</td>
            </tr>
            <tr>
                <td colspan="2">{{ $message->message }}</td>
            </tr>
        @else
            @foreach($inputs as $key => $input)
                <tr>
                    <th>{{ $input['label'] }}:</th>
                    <td>{{ $message->{$key} }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if ($message->items && count($message->items) && ($message->type == 'budget' || $message->type == 'shopping-cart'))
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
@if ($message->files && count($message->files))
<table class="table align-middle table-striped table-bordered">
    <thead>
        <tr>
            <th>Archivo adjunto</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($message->files as $item)
        <tr>
            <td><i class="fas fa-paperclip"></i> <a href="{{ asset(Storage::url($item->path)) }}" target="_blank">{{ $item->original_name }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection