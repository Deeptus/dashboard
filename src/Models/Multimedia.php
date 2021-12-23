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
	protected $casts = [];
	protected $appends = ['url'];
    public $translatable = [];

    public function getUrlAttribute() {
        return asset(Storage::url($this->getAttribute('path')));
    }

    public function getTypeAttribute() {
        if (Storage::exists($this->getAttribute('path'))) {
            return Storage::mimeType($this->getAttribute('path'));
        }
        return null;
    }
    
    public function getSizeAttribute() {
        if (Storage::exists($this->getAttribute('path'))) {
            return Storage::size($this->getAttribute('path'));
        }
        return null;
    }

    public function getWidthAttribute() {
        if (Storage::exists($this->getAttribute('path'))) {
            list($width, $height, $type, $attr) = getimagesize(Storage::path($this->getAttribute('path')));
            return $width;
        }
        return null;
    }

    public function getHeightAttribute() {
        if (Storage::exists($this->getAttribute('path'))) {
            list($width, $height, $type, $attr) = getimagesize(Storage::path($this->getAttribute('path')));
            return $height;
        }
        return null;
    }
}
