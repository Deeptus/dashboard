<?php

// Panel
Breadcrumbs::for('admin.home', function ($trail) {
	$trail->push('Panel', route('admin.home'));
});


// Panel > Contenido
Breadcrumbs::for('admin.dynamic-content', function ($trail, $section) {
    $trail->parent('admin.home');
    $trail->push('Contenido', route('admin.dynamic-content', ['seccion' => $section]));
});
// Panel > Contenido
Breadcrumbs::for('admin.content', function ($trail, $section) {
    $trail->parent('admin.home');
    $trail->push('Contenido', route('admin.content', ['seccion' => $section]));
});
// Panel > Contenido > Añadir
Breadcrumbs::for('admin.dynamic-content.create', function ($trail, $section) {
    $trail->parent('admin.dynamic-content', $section);
    $trail->push('Añadir', route('admin.dynamic-content.create', ['section' => $section]));
});
// Panel > Contenido > Editar
Breadcrumbs::for('admin.dynamic-content.edit', function ($trail, $element) {
    $trail->parent('admin.dynamic-content', $element->section);
    $trail->push('Editar a: ' . $element->title, route('admin.dynamic-content.edit', $element->id));
});
// Panel > Contenido > Papelera
Breadcrumbs::for('admin.dynamic-content.trash', function ($trail, $section) {
    $trail->parent('admin.dynamic-content', $section);
    $trail->push('Papelera', route('admin.dynamic-content.trash', ['section' => $section]));
});



// Panel > Grupo
Breadcrumbs::for('admin.grupo', function ($trail) {
	$trail->parent('admin.home');
	$trail->push('Grupo', route('admin.grupo'));
});
// Panel > Grupo > Añadir
Breadcrumbs::for('admin.grupo.create', function ($trail) {
	$trail->parent('admin.grupo');
	$trail->push('Añadir', route('admin.grupo.create'));
});
// Panel > Grupo > Editar
Breadcrumbs::for('admin.grupo.edit', function ($trail, $element) {
	$trail->parent('admin.grupo');
	$trail->push('Editar a: ' . $element->name, route('admin.grupo.edit', $element->id));
});
// Panel > Grupo > Papelera
Breadcrumbs::for('admin.grupo.trash', function ($trail) {
	$trail->parent('admin.grupo');
	$trail->push('Papelera', route('admin.grupo.trash'));
});
// Panel > Grupo > Editar
Breadcrumbs::for('admin.grupo.permission', function ($trail, $element) {
	$trail->parent('admin.grupo');
	$trail->push('Permisos de: ' . $element->name, route('admin.grupo.permission', $element->id));
});



// Panel > Usuario
Breadcrumbs::for('admin.user', function ($trail) {
	$trail->parent('admin.home');
	$trail->push('Usuario', route('admin.user'));
});
// Panel > Usuario > Añadir
Breadcrumbs::for('admin.user.create', function ($trail) {
	$trail->parent('admin.user');
	$trail->push('Añadir', route('admin.user.create'));
});
// Panel > Usuario > Editar
Breadcrumbs::for('admin.user.edit', function ($trail, $element) {
	$trail->parent('admin.user');
	$trail->push('Editar a: ' . $element->name, route('admin.user.edit', $element->id));
});
// Panel > Usuario > Papelera
Breadcrumbs::for('admin.user.trash', function ($trail) {
	$trail->parent('admin.user');
	$trail->push('Papelera', route('admin.user.trash'));
});
// Panel > Usuario > Editar
Breadcrumbs::for('admin.user.permission', function ($trail, $element) {
	$trail->parent('admin.user');
	$trail->push('Permisos de: ' . $element->name, route('admin.user.permission', $element->id));
});

// Panel > Traducciones
Breadcrumbs::for('admin.translation', function ($trail) {
	$trail->parent('admin.home');
	$trail->push('Traducciones', route('admin.translation'));
});
// Panel > Traducciones > Añadir
Breadcrumbs::for('admin.translation.create', function ($trail) {
	$trail->parent('admin.translation');
	$trail->push('Añadir', route('admin.translation.create'));
});
// Panel > Traducciones > Editar
Breadcrumbs::for('admin.translation.edit', function ($trail, $element) {
	$trail->parent('admin.translation');
	$trail->push('Editar a: ' . $element->name, route('admin.translation.edit', $element->id));
});
// Panel > Traducciones > Papelera
Breadcrumbs::for('admin.translation.trash', function ($trail) {
	$trail->parent('admin.translation');
	$trail->push('Papelera', route('admin.translation.trash'));
});

// Panel > Traducciones
Breadcrumbs::for('admin.seo', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('SEO', route('admin.seo'));
});
// Panel > Traducciones > Editar
Breadcrumbs::for('admin.seo.edit', function ($trail, $section) {
    $trail->parent('admin.seo');
    $trail->push('Editar a: ' . $section, route('admin.seo.edit', $section));
});
