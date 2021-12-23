@extends('Dashboard::layouts.dashboard')
@section('content')
<file-manager ref="FileManager" url-data="{{ route('admin.file-manager') }}" :inside-modal="false"></file-manager>
@endsection
