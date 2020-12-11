    <div class="mb-3">
        <label for="name"  class="form-label">Nombre y Apellido / Razon Social</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($element) ? $element->name : null) }}">
    </div>
    <div class="mb-3">
        <label for="username"  class="form-label">Nombre de Usuario <small style="color: red">(Es la palabra que va a utilizar para ingresar al sistema)</small></label>
        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', isset($element) ? $element->username : null) }}">
    </div>
    <div class="mb-3">
<label for="setting-input-1" class="form-label">Correo electrónico



    <span class="ml-2" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="This is a Bootstrap popover example. You can use popover to provide extra info." data-original-title="" title=""><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
  <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"></path>
  <circle cx="8" cy="4.5" r="1"></circle>
    </svg></span>
</label>


        <input type="text" class="form-control" id="email" name="email" value="{{ old('email', isset($element) ? $element->email : null) }}">
    </div>
