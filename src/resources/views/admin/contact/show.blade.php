@extends('Dashboard::layouts.dashboard')
@section('content')
<table class="table align-middle table-striped table-bordered">
    <tbody>
        @if(count($inputs) == 0)
            <tr>
                <th>Nombre:</td>
                <td>{{ $message->name }}</td>
            </tr>
            <tr>
                <th>Empresa:</td>
                <td>{{ $message->company }}</td>
            </tr>
            <tr>
                <th>Teléfono:</td>
                <td>{{ $message->phone }}</td>
            </tr>
            <tr>
                <th>Email:</td>
                <td>{{ $message->email }}</td>
            </tr>
            @if($message->address)
                <tr>
                    <th>Dirección:</td>
                    <td>{{ $message->address }}</td>
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
                    <th>{{ $input['label'] }}:</td>
                    <td>{{ $message->{$key} }}</td>
                </tr>
            @endforeach
        @endif
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