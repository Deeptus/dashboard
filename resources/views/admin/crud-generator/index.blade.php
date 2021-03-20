@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <div>

        <a href="{{ route('admin.crud-generator.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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
                    <th>Nombre</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item->getfilename() }}</td>
                    <td>
                        <a href="{{ route('admin.crud-generator.edit', [pathinfo($item->getfilename(), PATHINFO_FILENAME)]) }}" class="btn app-btn-primary">
                            <i class="fas fa-sm text-white-50 fa-edit"></i>
                            Editar
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection