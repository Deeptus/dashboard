<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Multimedia extends Model
{
    use HasTranslations, SoftDeletes;

    protected $table = 'multimedia';
	protected $fillable = [
        'path',
        'order',
        'filename',
        'alt',
        'caption',
        'original_name',
        'disk',
        'meta_value'
	];
	protected $casts = [
	];
    public $translatable = [];
}
