@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render(request()->route()->getName(), $section) !!}
    <div>
        @if (isset($trash) && $trash == true)
        <a href="{{ route('admin.dynamic-content', [$section]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Salir de la Papelera
        </a>
        @else
        <a href="{{ route('admin.dynamic-content.trash', [$section]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-trash fa-sm text-white-50"></i>
            Papelera
        </a>
        @endif
        <a href="{{ route('admin.dynamic-content.create', [$section]) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Añadir
        </a>
    </div>
</div>
@messages()
@endmessages
<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-12 col-md-12 mb-12">
        <table class="data_table table table-striped table-bordered display">
                @foreach ($data as $item)
                @if ($loop->first)
                    <thead>
                        <tr>
                            @if ($item->image != '')
                            <th>Imagen</th>
                            @endif
                            <th>Titulo</th>
                            <th class="no-sort"></th>
                        </tr>
                    </thead>
                    <tbody>
                @endif
                <tr>
                    @if ($item->image != '')
                    <td><img src="{{ asset(Storage::url($item->image)) }}" style="max-width: 50px; max-height: 50px;"></td>
                    @endif
                    <td>{{ $item->title }}</td>
                    <td>
                        @if (!$item->trashed())
                        <a href="{{ route('admin.dynamic-content.edit', [$item->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-sm text-white-50 fa-edit"></i>
                            Editar
                        </a>
                        <a href="{{ route('admin.dynamic-content.destroy', [$item->id]) }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-sm text-white-50 fa-trash-alt"></i>
                            Eliminar
                        </a>
                        @else
                        <a href="{{ route('admin.dynamic-content.restore', [$item->id]) }}" class="btn btn-warning btn-sm">
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
