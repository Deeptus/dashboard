<div class="card-body">
    @foreach (LaravelLocalization::getSupportedLocales() as $key => $lang)
    <fieldset>
        <legend>{{ $lang['name'] }}</legend>
        <div class="form-group">
            <label for="title-{{ $key }}">Titulo</label>
            <textarea name="title[{{ $key }}]" id="title-{{ $key }}" rows="2" class="form-control">{{ old('title.'.$key, isset($section) ? $section->getTranslation('title', $key) : null) }}</textarea>
        </div>
        <div class="form-group">
            <label for="description-{{ $key }}">Descripción</label>
            <textarea name="description[{{ $key }}]" id="description-{{ $key }}" rows="2" class="form-control">{{ old('description.'.$key, isset($section) ? $section->getTranslation('description', $key) : null) }}</textarea>
        </div>
        <div class="form-group">
            <label for="keywords-{{ $key }}">Palabras Claves</label>
            <textarea name="keywords[{{ $key }}]" id="keywords-{{ $key }}" rows="2" class="form-control">{{ old('keywords.'.$key, isset($section) ? $section->getTranslation('keywords', $key) : null) }}</textarea>
        </div>
    </fieldset>
    @endforeach
</div>
