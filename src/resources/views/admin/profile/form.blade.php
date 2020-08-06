<div class="card-body">
    <div class="form-group">
        <label for="name">Nombre y Apellido / Razon Social</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($element) ? $element->name : null) }}">
    </div>
    <div class="form-group">
        <label for="username">Nombre de Usuario <small style="color: red">(Es la palabra que va a utilizar para ingresar al sistema)</small></label>
        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', isset($element) ? $element->username : null) }}">
    </div>
    <div class="form-group">
        <label for="email">Correo electrónico <small style="color: red">(Es el correo a donde llegaran sus notificaciones)</small></label>
        <input type="text" class="form-control" id="email" name="email" value="{{ old('email', isset($element) ? $element->email : null) }}">
    </div>
</div>
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Clave de Acceso</h6>
</div>
<div class="card-body">
    <div class="input-group">
        <div class="input-group-prepend" id="button-addon3">
            {{-- <button class="btn btn-outline-secondary" type="button" id="random">
                <i class="fas fa-random"></i>
                Generar
            </button> --}}
            <button class="btn btn-outline-secondary" type="button" id="display">
                <i class="fas fa-eye"></i>
                Mostrar
            </button>
        </div>
        <input type="password" class="form-control" placeholder="Clave de Acceso" aria-label="Clave de Acceso" aria-describedby="button-addon3" id="password" name="password" autocomplete="new-password">
    </div>
</div>