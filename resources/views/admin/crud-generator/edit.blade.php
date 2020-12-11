@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">

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
    url-data="{{ route('admin.crud-generator.data', [$table]) }}"
    url-back="{{ route('admin.crud-generator') }}"
    url-action="{{ route('admin.crud-generator.store', [$table]) }}"
></crud-generator-form>
@endsection
