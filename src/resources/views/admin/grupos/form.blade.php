<div class="card-body">
	<div class="form-group">
		<label for="name">Nombre</label>
		<input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($element) ? $element->name : null) }}">
	</div>
	<div class="form-group">
		<label for="description">Descripción</label>
		<input type="text" class="form-control" id="description" name="description" value="{{ old('description', isset($element) ? $element->description : null) }}">
	</div>
    <div class="form-group">
        <label for="display_only_root">Mostrar solo para ROOT <small style="color: red">(Este permiso solo lo puede asignar un super administrador)</small></label>
        <select class="custom-select" id="display_only_root" name="display_only_root">
            <option value="0" {{ old('display_only_root', isset($element) ? $element->display_only_root : null)==0?'selected':'' }}>No</option>
            <option value="1" {{ old('display_only_root', isset($element) ? $element->display_only_root : null)==1?'selected':'' }}>Si</option>
        </select>
    </div>
</div>