@extends('Dashboard::layouts.dashboard')
@section('content')
<x-dashboard-messages/>
<div class="row">
    <div class="col-xl-12 col-md-12 mb-12">
        <table class="table table-striped table-bordered display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tabla</th>
                    <th>Contenido</th>
                    <th>Eliminado por</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->table }}</td>
                        <td style="white-space: pre;">{{ $item->data }}</td>
                        <td>{{ $item->deleted_by }}</td>
                        <td>{{ $item->created_at->format('d/m/Y h:i:s A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
</div>
@endsection
