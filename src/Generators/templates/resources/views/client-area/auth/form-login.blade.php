<div class="card">
    <div class="card-header">Usuarios Registrados</div>
    <div class="card-body">
        <form method="POST" action="{{ route('client.login') }}">
            @csrf

            <div class="form-group row">
                <label for="email" class="col-md-12 col-form-label">Correo Electronico</label>

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-12 col-form-label">Contraseña</label>

                <div class="col-md-12">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="text-muted" for="remember">
                            {{ __('Mantener sesión iniciada') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn-green mt-3 ps-5 pe-5">
                        {{ __('Ingresar') }}
                    </button>
                </div>

                <div class="col-md-12 text-center">
                    @if (Route::has('client.password.forgot'))
                        <a class="btn btn-link" href="{{ route('client.password.forgot') }}">
                            {{ __('Recuperar Contraseña') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
