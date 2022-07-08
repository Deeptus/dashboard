<?php

namespace AporteWeb\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Gallery extends Model
{
    use HasTranslations, SoftDeletes;

    protected $table = 'galleries';
	protected $fillable = [
        'description',
	];
	protected $casts = [
	];
    public $translatable = [];

    public function items()
    {
        return $this->belongsToMany(Multimedia::class, 'gallery_multimedia', 'gallery_id', 'multimedia_id')->withTimestamps()->withPivot('order')->orderBy('gallery_multimedia.order');
    }
}
