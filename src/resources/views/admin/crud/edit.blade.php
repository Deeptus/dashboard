@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render(request()->route()->getName(), $table, $item) !!}
    <div>
        <a href="{{ route('admin.crud', ['tablename' => $tablename]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Volver Atras
        </a>
    </div>
</div>
<x-dashboard-messages/>
<crud-form
    form-name="Editar"
    url-data="{{ route('admin.crud.data', ['tablename' => $tablename, 'id' => $item->pkv]) }}"
    url-back="{{ route('admin.crud', ['tablename' => $tablename]) }}"
    url-action="{{ route('admin.crud.store', ['tablename' => $tablename, 'id' => $item->pkv]) }}"
></crud-form>
@endsection
