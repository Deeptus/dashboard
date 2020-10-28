<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Translation extends Model
{
    use HasTranslations, SoftDeletes;

    protected $table = 'translations';
	protected $fillable = [
		'key',
		'translation',
	];
	protected $casts = [
	];
    public $translatable = [
        'translation',
	];
}
