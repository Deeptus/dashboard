@extends('Dashboard::layouts.dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="h3 mb-0 text-gray-800">Bienvenido, <strong>{{ auth()->user()->name }}</strong></div>
    {{--a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>--}}
</div>
<x-dashboard-messages/>

@endsection
