@extends('Dashboard::layouts.app')

@section('content')
<div class="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-4 text-center">
                @if (Storage::exists(__config_var('admin_logo')))
                    <img class="img-fluid" src="{{ asset(Storage::url(__config_var('admin_logo'))) }}">
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <x-dashboard-messages/>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard::message.login') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
    
                            <div class="form-floating mb-3">
                                <input
                                    id="username"
                                    type="text"
                                    class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                                    name="username"
                                    value="{{ old('username') }}"
                                    placeholder="{{ __('User name') }}"
                                    required
                                    autofocus
                                    autocomplete="off"
                                >
                                <label
                                    for="username"
                                >
                                    {{ __('User name') }}
                                </label>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="form-floating mb-3">
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password"
                                    placeholder="{{ __('Password') }}"
                                    required
                                >
                                <label
                                    for="password"
                                >{{ __('Password') }}</label>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                    <label class="form-check-label" for="remember">
                                        {{ __('Dashboard::message.remember_me') }}
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary ms-3">
                                    {{ __('Dashboard::message.login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
