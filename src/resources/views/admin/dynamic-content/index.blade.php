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
                            @foreach ($inputs as $input)
                                @if (
                                    is_array($config) &&
                                    array_key_exists('use-' . $input, $config) &&
                                    is_array($config['use-' . $input]) &&
                                    array_key_exists('display_index', $config['use-' . $input]) &&
                                    $config['use-' . $input]['display_index'] == true)
                                    <th>{{ $config['use-' . $input]['label'] }}</th>
                                @endif
                            @endforeach
                            @if ($item->image != '')
                            <th>Imagen</th>
                            @endif
                            <th class="no-sort"></th>
                        </tr>
                    </thead>
                <tbody>
                @endif
                <tr>
                    @foreach ($inputs as $input)
                        @if (
                            is_array($config) &&
                            array_key_exists('use-' . $input, $config) &&
                            is_array($config['use-' . $input]) &&
                            array_key_exists('display_index', $config['use-' . $input]) &&
                            $config['use-' . $input]['display_index'] == true)
                            <td>{{ $item->{$input} }}</td>
                        @endif
                    @endforeach
                    @if ($item->image != '')
                    <td><img src="{{ asset(Storage::url($item->image)) }}" style="max-width: 50px; max-height: 50px;"></td>
                    @endif
                    <td>
                        @if (!$item->trashed())
                        <a href="{{ route('admin.dynamic-content.edit', [$item->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-sm text-white-50 fa-edit"></i>
                            Editar
                        </a>
                        <a href="{{ route('admin.dynamic-content.copy', [$item->id]) }}" class="btn btn-warning btn-sm btn-confirm-copy">
                            <i class="fas fa-sm text-white-50 fa-copy"></i>
                            Duplicar
                        </a>
                        <a href="{{ route('admin.dynamic-content.destroy', [$item->id]) }}" class="btn btn-danger btn-sm btn-confirm-delete">
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
                @if ($loop->last)
                    </tbody>
                </table>
                @endif
            @endforeach
    </div>
</div>
@endsection
