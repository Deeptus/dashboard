@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render(request()->route()->getName()) !!}
    <div>
        @if (isset($trash) && $trash == true)
        <a href="{{ route('admin.email-layout') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Salir de la Papelera
        </a>
        @else
        <a href="{{ route('admin.email-layout.trash') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-trash fa-sm text-white-50"></i>
            Papelera
        </a>
        @endif
        <a href="{{ route('admin.email-layout.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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
        <table class="table table-striped table-bordered display">
            <thead>
                <tr>
                    @anypermission('display-dev-keys')
                    <th>Key</th>
                    @endanygroup
                    <th>Description</th>
                    <th>Subject</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    @anypermission('display-dev-keys')
                    <td>{{ $item->key }}</td>
                    @endanygroup
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->subject }}</td>
                    <td>
                        @if (!$item->trashed())
                            <a href="{{ route('admin.email-layout.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-sm text-white-50 fa-edit"></i>
                                Editar
                            </a>
                            <a href="{{ route('admin.email-layout.copy', $item->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-sm text-white-50 fa-copy"></i>
                                Duplicar
                            </a>
                            <a href="{{ route('admin.email-layout.destroy', $item->id) }}" class="btn btn-danger btn-sm">
                                <i class="fas fa-sm text-white-50 fa-trash-alt"></i>
                                Eliminar
                            </a>
                        @else
                            <a href="{{ route('admin.email-layout.restore', $item->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-sm text-white-50 fa-trash-restore"></i>
                                Restaurar
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $data->links() !!}
    </div>
</div>
@endsection
