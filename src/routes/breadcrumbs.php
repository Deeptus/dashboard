<?php

// Panel
Breadcrumbs::for('admin.home', function ($trail) {
	$trail->push('Dashboard', route('admin.home'));
});

//*************************************************************//

// Panel > Contenido
Breadcrumbs::for('admin.content', function ($trail, $section) {
    $trail->parent('admin.home');
    $trail->push('Contenido', route('admin.content', ['seccion' => $section]));
});

//*************************************************************//

Breadcrumbs::for('admin.profile', function ($trail, $section) {
    $trail->parent('admin.home');
    $trail->push('Editar mi perfil', route('admin.profile'));
});

//*************************************************************//

// Panel > Contenido Dinamico
Breadcrumbs::for('admin.dynamic-content', function ($trail, $section) {
    $trail->parent('admin.home');
    $trail->push('Contenido Dinamico', route('admin.dynamic-content', ['seccion' => $section]));
});
// Panel > Contenido Dinamico > Añadir
Breadcrumbs::for('admin.dynamic-content.create', function ($trail, $section) {
	$trail->parent('admin.dynamic-content', $section);
    $trail->push('Añadir', route('admin.dynamic-content.create', ['seccion' => $section]));
});
// Panel > Contenido Dinamico > Editar
Breadcrumbs::for('admin.dynamic-content.edit', function ($trail, $element) {
    $trail->parent('admin.dynamic-content', $element->section);
    $trail->push('Editar a: ' . $element->title, route('admin.dynamic-content.edit', $element->id));
});
// Panel > Contenido Dinamico > Papelera
Breadcrumbs::for('admin.dynamic-content.trash', function ($trail, $section) {
    $trail->parent('admin.dynamic-content', $section);
    $trail->push('Papelera', route('admin.dynamic-content.trash', ['seccion' => $section]));
});

//*************************************************************//

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

//*************************************************************//

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

//*************************************************************//

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

//*************************************************************//

// Panel > SEO
Breadcrumbs::for('admin.seo', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('SEO', route('admin.seo'));
});
// Panel > SEO > Editar
Breadcrumbs::for('admin.seo.edit', function ($trail, $section) {
    $trail->parent('admin.seo');
    $trail->push('Editar a: ' . $section, route('admin.seo.edit', $section));
});

//*************************************************************//

// Panel > CRUD Generator
Breadcrumbs::for('admin.crud-generator', function ($trail) {
	$trail->parent('admin.home');
	$trail->push('CRUD Generator', route('admin.crud-generator'));
});
// Panel > CRUD Generator > Añadir
Breadcrumbs::for('admin.crud-generator.create', function ($trail) {
	$trail->parent('admin.crud-generator');
	$trail->push('Añadir', route('admin.crud-generator.create'));
});
// Panel > CRUD Generator > Editar
Breadcrumbs::for('admin.crud-generator.edit', function ($trail, $table) {
	$trail->parent('admin.crud-generator');
	$trail->push('Editar : ' . $table, route('admin.crud-generator.edit', $table));
});
// Panel > CRUD Generator > Papelera
Breadcrumbs::for('admin.crud-generator.trash', function ($trail) {
	$trail->parent('admin.crud-generator');
	$trail->push('Papelera', route('admin.crud-generator.trash'));
});

//*************************************************************//

// Panel > CRUD
Breadcrumbs::for('admin.crud', function ($trail, $table) {
    $trail->parent('admin.home');
    $trail->push($table->name->{App::getLocale()}, route('admin.crud', ['tablename' => $table->tablename]));
});
// Panel > CRUD > Añadir
Breadcrumbs::for('admin.crud.create', function ($trail, $table) {
	$trail->parent('admin.crud', $table);
    $trail->push('Añadir', route('admin.crud.create', ['tablename' => $table->tablename]));
});
// Panel > CRUD > Editar
Breadcrumbs::for('admin.crud.edit', function ($trail, $table, $item) {
    $trail->parent('admin.crud', $table);
    $trail->push('Editar', route('admin.crud.edit', ['tablename' => $table->tablename, 'id' => $item->pkv]));
});
// Panel > CRUD > Papelera
Breadcrumbs::for('admin.crud.trash', function ($trail, $table) {
    $trail->parent('admin.crud', $table);
    $trail->push('Papelera', route('admin.crud.trash', ['tablename' => $table->tablename]));
});

//*************************************************************//

// Panel > Multimedia
Breadcrumbs::for('admin.multimedia', function ($trail) {
	$trail->parent('admin.home');
	$trail->push('Multimedia', route('admin.multimedia'));
});
// Panel > Multimedia > Añadir
Breadcrumbs::for('admin.multimedia.create', function ($trail) {
	$trail->parent('admin.multimedia');
	$trail->push('Añadir', route('admin.multimedia.create'));
});
// Panel > Multimedia > Editar
Breadcrumbs::for('admin.multimedia.edit', function ($trail, $element) {
	$trail->parent('admin.multimedia');
	$trail->push('Editar a: ' . $element->name, route('admin.multimedia.edit', $element->id));
});
// Panel > Multimedia > Papelera
Breadcrumbs::for('admin.multimedia.trash', function ($trail) {
	$trail->parent('admin.multimedia');
	$trail->push('Papelera', route('admin.multimedia.trash'));
});
