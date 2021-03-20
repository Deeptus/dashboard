@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render() !!}
</div>
<x-dashboard-messages/>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-12 col-md-12 mb-12">
        <table class="table table-striped table-bordered display">
            <thead>
                <tr>
                    <th>Secciones</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sections as $key => $section)
                <tr>
                    <td>{{ $section }} - <small>{{ $key }}</small></td>
                    <td>
                        <a href="{{ route('admin.seo.edit', [$key]) }}" class="btn app-btn-primary">
                            <i class="fas fa-sm text-white-50 fa-edit"></i>
                            Editar Meta Etiquetas
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
