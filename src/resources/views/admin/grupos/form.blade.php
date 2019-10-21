<div class="card-body">
	<div class="form-group">
		<label for="name">Nombre</label>
		<input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($element) ? $element->name : null) }}">
	</div>
	<div class="form-group">
		<label for="description">Descripción</label>
		<input type="text" class="form-control" id="description" name="description" value="{{ old('description', isset($element) ? $element->description : null) }}">
	</div>
</div>