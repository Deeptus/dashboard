@extends('Dashboard::layouts.dashboard')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    {!! Breadcrumbs::render(request()->route()->getName()) !!}
	<div>
		<a href="{{ route('admin.email-layout') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
			<i class="fas fa-step-backward fa-sm text-white-50"></i>
			Volver Atras
		</a>
	</div>
</div>
<x-dashboard-messages/>
<email-layout-form
    form-name="Añadir"
    url-data="{{ route('admin.email-layout.data') }}"
    url-back="{{ route('admin.email-layout') }}"
    url-action="{{ route('admin.email-layout.store') }}"
></email-layout-form>
@endsection
