@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    {!! Breadcrumbs::render(request()->route()->getName()) !!}
    <div>
        <a href="{{ route('admin.crud-generator') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Volver Atras
        </a>
    </div>
</div>
<x-dashboard-messages/>
<crud-generator-form
    form-name="Añadir"
    url-data="{{ route('admin.crud-generator.data') }}"
    url-back="{{ route('admin.crud-generator', ['paginate' => request()->paginate, 's' => request()->s, 'page' => request()->page]) }}"
    url-action="{{ route('admin.crud-generator.store') }}"
    endpoint="{{ route('admin.crud-generator') }}"
></crud-generator-form>
@endsection
