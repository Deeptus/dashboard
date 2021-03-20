@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))

<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
                    <div class="inner">
                        <div class="app-card-body p-3 p-lg-4">
                            <h3 class="mb-3">Exito!</h3>
                            <div class="row gx-5 gy-3">
                                <div class="col-12 col-lg-9">
                                    
                                    <div>{!! session('success') !!}</div>
                                </div><!--//col-->

                            </div><!--//row-->
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                        </div><!--//app-card-body-->
                        
                    </div><!--//inner-->
                </div>
{{--
<div class="row">
    <div class="col-xl-12 col-md-12 mb-12">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('Dashboard::message.message') }}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {!! session('success') !!}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comment fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>--}}
@endif
@if (session('token_mismatch_error'))
<div class="row">
    <div class="col-xl-12 col-md-12 mb-12">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Error</div>
                        <div class="h5 mb-2 font-weight-bold text-gray-800">
                            {{ __('Dashboard::message.token_mismatch') }}
                        </div>
                        <p class="text-muted mb-0">{{ __('Dashboard::message.token_mismatch_comment') }}.</p>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comment fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
@endif
@if (session('danger'))
<div class="row">
    <div class="col-xl-12 col-md-12 mb-12">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">{{ __('Dashboard::message.message') }}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {!! session('danger') !!}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comment fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
@endif

