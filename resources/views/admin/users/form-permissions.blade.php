@php($group_permissions = $element->permissions()->pluck('id')->toArray());
<div class="card-body">
	<div class="row">
		@foreach ($permissions as $permission)
		<div class="col-md-3">
			<div class="custom-control custom-switch">
				<input
				type="checkbox"
				class="custom-control-input"
				id="permission-{{ $permission->id }}"
				name="permissions[]"
				value="{{ $permission->id }}"
				{{ in_array($permission->id, $group_permissions)?'checked':'' }}
				>
				<label class="custom-control-label" for="permission-{{ $permission->id }}">
					{{ $permission->name }}
					<small>{{ $permission->slug }}</small>
				</label>
			</div>
		</div>
		@endforeach
	</div>
</div>