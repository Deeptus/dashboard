<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;

class MultimediaMeta extends Model {

    protected $table = 'multimedia_meta';
	protected $fillable = [
        'multimedia_id',
        'meta_key',
        'meta_value'
	];
}
