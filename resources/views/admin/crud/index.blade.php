@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">

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

        @can($tablename.'-edit')
        <a href="{{ route('admin.crud.create', ['tablename' => $tablename]) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Añadir
        </a>
        @endcan

    </div>
</div>
<x-dashboard-messages/>
<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-12 col-md-12 mb-12">

        <div class="table-responsive">
        @foreach ($data as $item)
            @if ($loop->first)
            <!-- <table class="data_table table table-striped table-bordered display"> ------>

                <table class="data_table  table app-table-hover mb-0 text-left">
                <thead>
                    <tr>
                        @foreach ($inputs as $inputKey => $input)
                        @if(isset($input->visible) && $input->visible == 1)
                            <th class="cell">{{ $input->label->{App::getLocale()} }} </th>
                        @endif
                        @endforeach                
                        <th class="cell"> - </th>
                    </tr>
                </thead>
                <tbody>
                @endif
                <tr>
                    @foreach ($inputs as $inputKey => $input)
                    @if(isset($input->visible) &&  $input->visible == 1)



                   <td class="cell">


                       @if($input->type == 'select' && $input->valueoriginselector == 'values')

                                
                                @foreach($input->options as $opt)

                                    @if($item->{$input->columnname} == $opt->key) {{ $opt->text}} @endif

                                @endforeach

                        @elseif($input->type == 'select' && $input->valueoriginselector == 'table')

                            @php

                                //$finder = \DB::select('select * from '.$input->tabledata.' where '.$input->tablekeycolumn.' = '.$item->{$input->columnname}, [1]);
                                $finder = \DB::table($input->tabledata)->where($input->tablekeycolumn, $item->{$input->columnname})->pluck($input->tabletextcolumn);

                            @endphp
                            {{$finder[0] }}

                            @if(isset($finder->{$input->tabletextcolumn}))
                            @endif

                            {{-- $input->tabledata }} - {{ $input->tabletextcolumn }} - {{ $input->tablekeycolumn --}}

                        @elseif($input->type == 'true_or_false')

                            @if($item->{$input->columnname} == 0)
                            <div class="badge bg-danger">
                            <i class="fas fa-times"></i>
                            </div>
                            @else
                            <div class="badge bg-success">
                            <i class="fas fa-check"></i>
                            </div>
                            @endif

                        @else

                        {{ $item->{$input->columnname} }}

                       @endif

                    </td>



                    @endif
                    @endforeach
                   <td class="cell" data-sortable="false">
                        @if (!$item->trashed())
                        <a href="{{ route('admin.crud.edit', ['tablename' => $tablename, 'id' => $item->id]) }}" class="btn btn-sm app-btn-primary">
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
        </div>
    </div>
</div>
@endsection
