@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render(request()->route()->getName(), $table) !!}
    <div>
        @if (isset($trash) && $trash == true)
        <a href="{{ route('admin.crud', ['tablename' => $tablename]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Salir de la Papelera
        </a>
        @else
        <a href="{{ route('admin.crud.trash', ['tablename' => $tablename]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-trash fa-sm text-white-50"></i>
            Papelera
        </a>
        @endif
        <a href="{{ route('admin.crud.create', ['tablename' => $tablename]) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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
        @foreach ($data as $item)
            @if ($loop->first)
            <table class="data_table table table-striped table-bordered display">
                <thead>
                    <tr>
                        @foreach ($inputs as $inputKey => $input)
                            <?php
                            if ( $input->type == 'card-header' || ( property_exists($input, 'listable') && $input->listable == 0 ) ) {
                                continue;
                            }
                            ?>
                            <th>{{ $input->label->{App::getLocale()} }}</th>
                        @endforeach                
                        <th class="no-sort"></th>
                    </tr>
                </thead>
                <tbody>
                @endif
                <tr>
                    @foreach ($inputs as $inputKey => $input)
                    <?php
                    if ( $input->type == 'card-header' || ( property_exists($input, 'listable') && $input->listable == 0 ) ) {
                        continue;
                    }
                    ?>
                    @if ($input->type == 'select')
                        <td>{{ $item->{$input->columnname . '_rel_val'} }}</td>
                    @else
                        <td>{{ $item->{$input->columnname} }}</td>
                    @endif
                    @endforeach
                    <td>
                        @if (!$item->trashed())
                        <a href="{{ route('admin.crud.edit', ['tablename' => $tablename, 'id' => $item->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-sm text-white-50 fa-edit"></i>
                            Editar
                        </a>
                        <a href="{{ route('admin.crud.copy', ['tablename' => $tablename, 'id' => $item->id]) }}" class="btn btn-warning btn-sm btn-confirm-copy">
                            <i class="fas fa-sm text-white-50 fa-copy"></i>
                            Duplicar
                        </a>
                        <a href="{{ route('admin.crud.destroy', ['tablename' => $tablename, 'id' => $item->id]) }}" class="btn btn-danger btn-sm btn-confirm-delete">
                            <i class="fas fa-sm text-white-50 fa-trash-alt"></i>
                            Eliminar
                        </a>
                        @else
                        <a href="{{ route('admin.crud.restore', ['tablename' => $tablename, 'id' => $item->id]) }}" class="btn btn-warning btn-sm">
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
    </div>
</div>
@endsection
