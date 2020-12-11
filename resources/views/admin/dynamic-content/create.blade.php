@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render(request()->route()->getName(), $section) !!}
    <div>
        <a href="{{ route('admin.dynamic-content', [$section]) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
            <i class="fas fa-step-backward fa-sm text-white-50"></i>
            Volver Atras
        </a>
    </div>
</div>
<x-dashboard-messages/>
<dynamic-content-form
    form-name="Añadir"
    url-data="{{ route('admin.dynamic-content.data', [$section]) }}"
    url-back="{{ route('admin.dynamic-content', [$section]) }}"
    url-action="{{ route('admin.dynamic-content.store', [$section]) }}"
></dynamic-content-form>
@endsection
