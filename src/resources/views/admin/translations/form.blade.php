<div class="card-body">
	<div class="form-group">
		<label for="codigo">key</label>
        <input type="text" class="form-control" name="key" id="key" value="{{ old('key', isset($element) ? $element->key : null) }}">
    </div>
    @foreach (LaravelLocalization::getSupportedLocales() as $key => $lang)
        <div class="form-group">
            <label for="codigo">Traducir a: <strong>{{ $lang['name'] }}</strong></label>
            <textarea name="translation[{{ $key }}]" id="translation[{{ $key }}]" rows="2" class="form-control">{{ old('translation.'.$key, isset($element) ? $element->getTranslation('translation', $key) : null) }}</textarea>
        </div>
    @endforeach
</div>
