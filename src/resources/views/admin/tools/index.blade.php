@extends('Dashboard::layouts.dashboard')
@section('content')
<x-dashboard-messages/>

<table class="table">
    <thead>
        <tr>
            <th>Acciones</th>
            <th>Explicación</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <a href="{{ route('admin.tools.cache-clear') }}" class="btn btn-danger">Clear Cache</a>
            </td>
            <td>
                Limpia la cache de la aplicación
            </td>
        </tr>
        <tr>
            <td>
                <a href="{{ route('admin.tools.cache-clear-all') }}" class="btn btn-danger">Clear All Cache</a>
            </td>
            <td>
                Limpia toda la cache de la aplicación
            </td>
        </tr>
    </tbody>
</table>
@endsection
