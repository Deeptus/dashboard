@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render() !!}
    <div>
        @if (isset($trash) && $trash == true)
        <a href="{{ route('admin.multimedia') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Salir de la Papelera
        </a>
        @else
        <a href="{{ route('admin.multimedia', ['enable-trash']) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-trash fa-sm text-white-50"></i>
            Papelera
        </a>
        @endif
        {{--
        <a href="{{ route('admin.multimedia.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Añadir
        </a>
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
        @foreach ($data as $item)
            @if ($loop->first)
            <table class="table table-striped table-bordered display">
                <thead>
                    <tr>
                        <th>Preview</th>
                    </tr>
                </thead>
                <tbody>
                @endif
                <tr>
                    <td><div style="background-image: url('{{ asset(Storage::url($item->path)) }}');width: 50px;height: 50px;background-position: center;background-size: cover;background-repeat: no-repeat;margin: auto;"></div></td>
                    <td>
                        @if (!$item->trashed())
                        {{--
                        <a href="{{ route('admin.multimedia.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-sm text-white-50 fa-edit"></i>
                            Editar
                        </a>
                        --}}
                        <a href="{{ route('admin.multimedia.destroy', ['id' => $item->id]) }}" class="btn btn-danger btn-sm btn-confirm-delete">
                            <i class="fas fa-sm text-white-50 fa-trash-alt"></i>
                            Eliminar
                        </a>
                        @else
                        <a href="{{ route('admin.multimedia.restore', ['id' => $item->id]) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-sm text-white-50 fa-trash-restore"></i>
                            Restaurar
                        </a>
                        @endif
                    </td>
                </tr>
            @if ($loop->last)
                </tbody>
            </table>
            @endif
        @endforeach
        {{ $data->links() }}
    </div>
</div>
@endsection
