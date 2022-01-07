@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render() !!}
    <div>
        @if (isset($trash) && $trash == true)
        <a href="{{ route('admin.crud-generator', ['paginate' => request()->paginate, 's' => request()->s, 'page' => request()->page]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Salir de la Papelera
        </a>
        @else
        <a href="{{ route('admin.crud-generator.trash', ['paginate' => request()->paginate, 's' => request()->s, 'page' => request()->page]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-trash fa-sm text-white-50"></i>
            Papelera
        </a>
        @endif
        <a href="{{ route('admin.crud-generator.create', ['paginate' => request()->paginate, 's' => request()->s, 'page' => request()->page]) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Añadir
        </a>
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
        <table class="table table-striped table-bordered display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Table exists in database</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['table_exist'] ? 'Yes' : 'No' }}</td>
                    <td>
                        @if($item['menu'] == 'crud')
                        <a
                            href="{{ route('admin.crud-generator.edit', [pathinfo($item['name'], PATHINFO_FILENAME), 'paginate' => request()->paginate, 's' => request()->s, 'page' => request()->page]) }}"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-sm text-white-50 fa-edit"></i>
                            Edit
                        </a>
                        <btn-link
                            href="{{ route('admin.crud-generator.fix', [pathinfo($item['name'], PATHINFO_FILENAME), 'paginate' => request()->paginate, 's' => request()->s, 'page' => request()->page]) }}"
                            class="btn btn-danger btn-sm"
                            confirm-text="¿Está seguro de corregir esta tabla?">
                            <i class="fas fa-sm text-white-50 fa-tools"></i>
                            Fix
                        </btn-link>
                        <btn-link
                            href="{{ route('admin.crud-generator.seed-generate', [pathinfo($item['name'], PATHINFO_FILENAME), 'paginate' => request()->paginate, 's' => request()->s, 'page' => request()->page]) }}"
                            class="btn btn-warning btn-sm"
                            confirm-text="¿Está seguro de generar los datos de esta tabla?">
                            <i class="fas fa-sm text-white-50 fa-database"></i>
                            Generate SEED
                        </btn-link>
                        <btn-link
                            href="{{ route('admin.crud-generator.seed-restore', [pathinfo($item['name'], PATHINFO_FILENAME), 'paginate' => request()->paginate, 's' => request()->s, 'page' => request()->page]) }}"
                            class="btn btn-warning btn-sm"
                            confirm-text="¿Está seguro de restaurar los datos de esta tabla?">
                            <i class="fas fa-sm text-white-50 fa-database"></i>
                            Restore SEED
                        </btn-link>
                        <btn-link
                            href="{{ route('admin.crud', [pathinfo($item['name'], PATHINFO_FILENAME)]) }}"
                            class="btn btn-secondary btn-sm"
                            confirm-text="¿Está seguro de ver esta tabla?">
                            <i class="fas fa-sm text-white-50 fa-external-link-alt"></i>
                            Go
                        </btn-link>
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