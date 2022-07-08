@extends('Dashboard::layouts.dashboard')
@section('content')
<x-dashboard-messages/>
<company-data-form
    form-name="Editar datos de la empresa"
    url-data="{{ route('admin.companydata.data') }}"
    url-back="{{ route('admin.companydata') }}"
    url-action="{{ route('admin.companydata.update') }}"
></company-data-form>
@endsection
