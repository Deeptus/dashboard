@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <div>
        @if (isset($trash) && $trash == true)
        <a href="{{ route('admin.user') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Salir de la Papelera
        </a>
        @else
        <a href="{{ route('admin.user.trash') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-trash fa-sm text-white-50"></i>
            Papelera
        </a>
        @endif
        <a href="{{ route('admin.user.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Añadir
        </a>
    </div>
</div>
<x-dashboard-messages/>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-12 col-md-12 mb-12">
        <table class="data_table table table-striped table-bordered display">
            <thead>
                <tr>
                    <th>Nombre y Apellido</th>
                    <th>Nombre de Usuario</th>
                    <th>Correo electrónico</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        @if (!$item->trashed())
                        <a href="{{ route('admin.user.edit', [$item->id]) }}" class="btn app-btn-primary">
                            <i class="fas fa-sm text-white-50 fa-edit"></i>
                            Editar
                        </a>
                        @if (2==3)
                        <a href="{{ route('admin.user.permission', [$item->id]) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-sm text-white-50 fa-key"></i>
                            Permisos
                        </a>
                        @endif
                        <a href="{{ route('admin.user.destroy', [$item->id]) }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-sm text-white-50 fa-trash-alt"></i>
                            Eliminar
                        </a>
                        @else
                        <a href="{{ route('admin.user.restore', [$item->id]) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-sm text-white-50 fa-trash-restore"></i>
                            Restaurar
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
