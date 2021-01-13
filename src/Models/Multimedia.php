<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Storage;

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

    public function getUrlAttribute(Type $var = null)
    {
        return asset(Storage::url($this->getAttribute('path')));
    }
    public function getTypeAttribute(Type $var = null)
    {
        return Storage::mimeType($this->getAttribute('path'));
    }
}
