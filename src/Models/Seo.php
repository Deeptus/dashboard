<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Seo extends Model
{
    use HasTranslations, SoftDeletes;

    protected $table = 'seo';
	protected $fillable = [
        'section',
        'image',
        'type',
        'title',
        'description',
		'keywords',
	];
	protected $casts = [
	];
    public $translatable = [
        'title',
        'description',
        'keywords',
	];
}
