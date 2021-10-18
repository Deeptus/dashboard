@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {{--!! Breadcrumbs::render(request()->route()->getName(), $type) !!--}}
    <div>
        @if (isset($trash) && $trash == true)
        <a href="{{ route('admin.contact', ['type' => $type]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Salir de la Papelera
        </a>
        @else
        <a href="{{ route('admin.contact.trash', ['type' => $type]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-trash fa-sm text-white-50"></i>
            Papelera
        </a>
        @endif
        {{--
        @if ($enable_create)
        <a href="{{ route('admin.contact.create', ['type' => $type]) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Añadir
        </a>
        @endif
        --}}
    </div>
</div>
<x-dashboard-messages/>
<form class="row mb-3">
    <div class="form-group offset-md-4 col-md-4">
        <label for="search_s">Buscar</label>
        <input id="search_s" type="text" class="form-control" value="{{ request()->has('s')?request()->s:'' }}" name="s">
    </div>
    <div class="form-group col-md-2">
        <label>Mostrar</label>
        <select class="form-select" name="paginate">
            @foreach ([10, 20, 50, 100] as $paginate)
            <option value="{{ $paginate }}" {{ request()->has('paginate') && request()->paginate == $paginate ? 'selected' : '' }}>{{ $paginate }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-2">
        <label for="search_p" style="opacity: 0">s</label> <br>
        <button class="btn btn-outline-secondary w-100 text-nowrap" type="submit">
            <i class="fas fa-search"></i>
            Buscar
        </button>
    </div>
</form>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-12 col-md-12 mb-12">
        <table class="table table-striped table-bordered display table-layout-fixed">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td><a href="{{ route('admin.contact.show', ['type' => $item->type, 'id' => $item->uuid]) }}">{{ $item->name }}</a></td>
                    <td>{{ $item->company }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->email }}</td>
                    {{--
                    <td>
                        @if (!$item->trashed())
                        <a href="{{ route('admin.contact.show', ['type' => $item->type, 'id' => $item->uuid]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-sm text-white-50 fa-eye"></i>
                            Ver
                        </a>
                        <a href="{{ route('admin.contact.destroy', ['type' => $item->type, 'id' => $item->uuid]) }}" class="btn btn-danger btn-sm btn-confirm-delete">
                            <i class="fas fa-sm text-white-50 fa-trash-alt"></i>
                            Eliminar
                        </a>
                        @else
                        <a href="{{ route('admin.contact.restore', ['type' => $item->type, 'id' => $item->uuid]) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-sm text-white-50 fa-trash-restore"></i>
                            Restaurar
                        </a>
                        @endif
                    </td>
                    --}}
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
</div>
@endsection